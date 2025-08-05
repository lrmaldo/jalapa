<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Tienda;
use Livewire\Component;

class Principal extends Component
{
    public $search = '';
    public $select_categoria = null;
    public $sort = 'id';
    public $direction = 'desc';
    public $isLoading = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'select_categoria' => ['except' => null],
        'direction' => ['except' => 'desc']
    ];

    // Optimización: Agregar debounce para la búsqueda
    protected $listeners = [
        'search-updated' => 'updateSearch'
    ];

    public function mount()
    {
        // Inicialización limpia
    }

    public function updating($propertyName)
    {
        // Mostrar loading state cuando se actualiza cualquier propiedad
        $this->isLoading = true;
    }

    public function updated($propertyName)
    {
        // Resetear loading state después de la actualización
        $this->isLoading = false;

        // Si se actualiza la búsqueda, resetear la categoría para mejor UX
        if ($propertyName === 'search' && !empty($this->search)) {
            // Opcional: mantener ambos filtros activos
            // $this->select_categoria = null;
        }
    }

    public function render()
    {
        // Cache de categorías para evitar consultas repetitivas
        $categorias = cache()->remember('categorias_activas', 3600, function () {
            return Categoria::select('categorias.id', 'categorias.nombre')
                ->join('tiendas', 'categorias.id', '=', 'tiendas.categoria_id')
                ->where('tiendas.is_active', 1)
                ->groupBy('categorias.id', 'categorias.nombre')
                ->orderBy('categorias.nombre')
                ->get();
        });

        // Optimizar la consulta de tiendas
        $tiendas = $this->getTiendasOptimized();

        return view('livewire.principal', [
            'tiendas' => $tiendas,
            'categorias' => $categorias
        ]);
    }

    private function getTiendasOptimized()
    {
        $query = Tienda::with(['categoria:id,nombre'])
            ->where('is_active', 1);

        // Aplicar filtro de búsqueda si existe
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', $searchTerm)
                  ->orWhere('direccion', 'LIKE', $searchTerm);
            });
        }

        // Aplicar filtro de categoría si existe
        if (!is_null($this->select_categoria)) {
            $query->where('categoria_id', $this->select_categoria);
        }

        // Aplicar ordenamiento
        $query->orderBy($this->sort, $this->direction);

        return $query->get();
    }

    public function seleccionarCategoria($cat)
    {
        $this->isLoading = true;
        $this->select_categoria = $cat;
        $this->isLoading = false;
    }

    public function resetFilters()
    {
        $this->isLoading = true;
        $this->reset(['select_categoria', 'search']);
        $this->isLoading = false;
    }

    // Método para actualizar búsqueda con debounce desde JavaScript
    public function updateSearch($searchTerm)
    {
        $this->search = $searchTerm;
    }

    // Método para cambiar ordenamiento
    public function updateSort($field, $direction)
    {
        $this->sort = $field;
        $this->direction = $direction;
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Tienda;
use Livewire\Component;

class Principal extends Component
{
    public $search, $select_categoria = null, $sort = 'id', $direction = 'desc';
    // Añadimos el listener para actualizar en tiempo real
    protected $listeners = ['seleccionarCategoria', 'resetFilters'];

    public function mount(){
        //$this->tiendas = [] ;
    }

    public function render()
    {
        $buscar = $this->search;
        $categorias = Categoria::select('id','nombre')->get();

        // Mejoramos la lógica de consulta para mejor filtrado
        $query = Tienda::where('is_active', 1);

        // Aplicamos filtro de búsqueda si hay texto
        if (!empty($buscar)) {
            $query->where('nombre', 'LIKE', "%{$buscar}%");
        }

        // Aplicamos filtro de categoría si hay una seleccionada
        if (!is_null($this->select_categoria)) {
            $query->where('categoria_id', $this->select_categoria);
        }

        // Ordenamos los resultados
        $tiendas = $query->orderBy($this->sort, $this->direction)->get();

        return view('livewire.principal', [
            'tiendas' => $tiendas,
            'categorias' => $categorias
        ]);
    }

    public function seleccionarCategoria($cat)
    {
        $this->select_categoria = $cat;
    }

    public function resetFilters()
    {
        $this->reset('select_categoria');
    }
}

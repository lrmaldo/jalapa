<?php

namespace App\Http\Livewire\Frotend;

use App\Models\Categoria_tienda;
use App\Models\Producto;
use Livewire\Component;
use App\Models\Tienda as ModelTienda;

class Tienda extends Component
{
    public $id_tienda;
    public $search, $select_categoria = null, $sort = 'id', $direction = 'desc';

    public function mount($id_tienda)
    {
        $this->id_tienda = $id_tienda;
    }

    public function render()
    {
        $categorias = Categoria_tienda::select('id', 'nombre')->where('tienda_id', $this->id_tienda)->get();
        $catSelect = $this->select_categoria;
        $tienda = ModelTienda::find($this->id_tienda);
        $buscar = $this->search;

        // Consulta base
        $query = Producto::where('tienda_id', $this->id_tienda)
                        ->where('is_active', 1);

        // Aplicar filtro de búsqueda si existe
        if (!empty($buscar)) {
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
            });
        }

        // Aplicar filtro de categoría si está seleccionada
        if (!is_null($catSelect)) {
            $query->where('categoria_id', $catSelect);
        }

        // Aplicar ordenamiento
        if ($this->direction === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($this->direction === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('precio', $this->direction);
        }

        // Ejecutar consulta con paginación
        $productos = $query->paginate(15);

        return view('livewire.frotend.tienda', compact('tienda', 'productos', 'categorias', 'catSelect'));
    }

    public function seleccionarCategoria($cat)
    {
        /* obtiene el id de la categoria */
        $this->select_categoria = $cat;
    }

    public function resetFilters()
    {
        $this->reset('select_categoria');
    }

    /**
     * Reiniciar todos los filtros y la búsqueda
     */
    public function resetAll()
    {
        $this->search = '';
        $this->select_categoria = null;
        $this->resetPage();
    }

    public function resetPage()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['page']);
    }
}

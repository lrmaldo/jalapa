<?php

namespace App\Http\Livewire\Frotend;

use App\Models\Categoria_tienda;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tienda as ModelTienda;

class Tienda extends Component
{
    use WithPagination;

    public $id_tienda;
    public $search = '';
    public $select_categoria = null;
    public $sort = 'id';
    public $direction = 'desc';

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'search' => ['except' => ''],
        'select_categoria' => ['except' => null],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc']
    ];

    public function mount($id_tienda)
    {
        $this->id_tienda = $id_tienda;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectCategoria()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function updatingDirection()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categorias = Categoria_tienda::select('id', 'nombre')
            ->where('tienda_id', $this->id_tienda)
            ->orderBy('nombre')
            ->get();

        $tienda = ModelTienda::find($this->id_tienda);

        $productos = Producto::where('tienda_id', $this->id_tienda)
            ->where('is_active', 1)
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nombre', 'LIKE', $search)
                             ->orWhere('descripcion', 'LIKE', $search);
                });
            })
            ->when($this->select_categoria, function ($query) {
                $query->where('categoria_id', $this->select_categoria);
            })
            ->with('categoria')
            ->orderBy($this->sort, $this->direction)
            ->paginate(12);

        return view('livewire.frotend.tienda', compact('tienda', 'productos', 'categorias'));
    }

    public function seleccionarCategoria($categoria_id)
    {
        $this->select_categoria = $categoria_id;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['select_categoria', 'search']);
        $this->resetPage();
    }
}

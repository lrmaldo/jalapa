<?php

namespace App\Http\Livewire\Frotend;

use App\Models\Categoria_tienda;
use App\Models\Producto;
use Livewire\Component;
use App\Models\Tienda as ModelTienda;

class Tienda extends Component
{
    public $id_tienda;
    public $search, $select_categoria =null ,$sort = 'id', $direction ='desc';
    public function mount($id_tienda)
    {
        $this->id_tienda = $id_tienda;
    }
    public function render()
    {
        $categorias = Categoria_tienda::select('id','nombre')->where('tienda_id',$this->id_tienda)->get();
        $catSelect = $this->select_categoria;
        $tienda = ModelTienda::find($this->id_tienda);
        $buscar = $this->search;
       # dd($catSelect);
        $productos = Producto::where('tienda_id',$this->id_tienda)
        ->where('is_active',1)
        ->where(function($query)  use ($buscar, $catSelect){

            $query->orWhere('nombre','LIKE',"%{$buscar}%");
            $query->orWhere('descripcion','LIKE',"%{$buscar}%");

            if(!is_null($catSelect)){
               #dd($this->select_categoria);
               #dd($catSelect);
               $query->where('categoria_id',$catSelect);

            }
        })

       /*  ->orWhere('categoria_id',$this->select_categoria) */
        ->orderBy($this->sort,$this->direction)
        ->paginate(15);
        //dd($productos);
        return view('livewire.frotend.tienda', compact('tienda','productos','categorias','catSelect'));
    }

    public function seleccionarCategoria($cat){
        /* obtiene el id de la categoria */
        $this->select_categoria =$cat;
    }

    public function resetFilters(){
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
}

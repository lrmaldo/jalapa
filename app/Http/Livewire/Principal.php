<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Tienda;
use Livewire\Component;

class Principal extends Component
{
    public $search, $select_categoria =null ,$sort = 'id', $direction ='desc';

    public function mount(){
        //$this->tiendas = [] ;
    }

    public function render()
    {
        $buscar = $this->search;
        $categorias = Categoria::select('id','nombre')->get();
        $catSelect = $this->select_categoria;
        $tiendas;
       /*  if(is_null($this->select_categoria)){ */
            $tiendas =Tienda::where(function($query) use ($buscar) {
                $query->where('is_active', true);
                $query->orWhere('nombre', 'LIKE',"%{$buscar}%");
               /*  dd($this->select_categoria); */
               if(!is_null($this->select_categoria)){
                   $query->where('categoria_id',$this->select_categoria);

               }
                
            })
            /* ->where('categoria_id',$this->select_categoria) */
            ->orderBy($this->sort, $this->direction)
            ->get();
            

        /* } */

        return view('livewire.principal',['tiendas'=>$tiendas,'categorias'=>$categorias]);
    }

   
    public function seleccionarCategoria($cat){
        /* obtiene el id de la categoria */
        $this->select_categoria =$cat;
    }

    public function resetFilters(){
        $this->reset('select_categoria');
    }

    
}

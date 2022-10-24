<?php

namespace App\Http\Livewire\Frotend;

use Livewire\Component;

class Tienda extends Component
{
    public $id_tienda;
    public function mount($id_tienda)
    {
        $this->id_tienda = $id_tienda;
    }
    public function render()
    {
        $tienda = Tienda::find($this->id_tienda);

        return view('livewire.frotend.tienda', compact('tienda'));
    }
}

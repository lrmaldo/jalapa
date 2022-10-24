<?php

namespace App\Http\Controllers;

use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function cartList(){
        return view('cart');
    }

    public function addToCart(Request $request){
        Cart::add([
            'id'=>$request->id,
            'name'=>$request->nombre,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'atributes'=>[
                'image'=>$request->image,
            ]
            ]);
            session()->flash('success','Producto agregado correctamente');
            
    }
}

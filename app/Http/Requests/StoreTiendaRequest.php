<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTiendaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categoria_id'=>['required'],
            'tipo_tienda'=>['required'],
        ];
    }
    public function messages()
    {
        return [
            'categoria_id.required'=>"Categorias es requerido",
            'tipo_tienda.required'=>"Tipo de tienda es requerido",
        ] ;    
    }
}

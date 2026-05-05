<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloRequest extends FormRequest
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
            'nombre'=>'required',
            'id_categoria'=>'required',
            // 'tipo'=>'required',


        ];
    }
    public function messages()
    {
        return [
            'nombre.required'=>'El nombre del Producto no puede estar vacio',
            'id_categoria.required'=>'Seleccione una Categoria',
            // 'tipo.required'=>'Seleccione el Tipo',


        ];
    }
}

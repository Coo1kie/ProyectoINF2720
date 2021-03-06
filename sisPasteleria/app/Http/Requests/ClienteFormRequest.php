<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
class ClienteFormRequest extends FormRequest
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
            'nombre'=>'required|max:100',
            'tipo_documento'=>'required|max:20',
            'num_documento'=>'required|max:11',
            'direccion'=>'max:100',
            'telefono'=>'max:15',
           // 'estado'=>'required|max:20'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicoRequest extends FormRequest
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
            'Nombre' => 'alpha|required|min:1',
            'Apellido' => 'required|min:1',
            'Correo' => 'required|min:1',
            'Contrasenia' => 'required|min:8',
            'Habilitado' => 'required',
            'Celular' => 'required|min:9|max:9'
        ];
    }
}

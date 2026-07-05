<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // La autorización se delega a la Policy en el Controller
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'nombre'           => ['required', 'string', 'max:100'],
            'apellido_paterno' => ['required', 'string', 'max:100'],
            'apellido_materno' => ['nullable', 'string', 'max:100'],
            'telefono'         => ['nullable', 'string', 'max:20'],
            'email'            => ['nullable', 'email:rfc,dns', 'max:180', Rule::unique('clientes', 'email')->withoutTrashed()],
            'rfc'              => ['nullable', 'string', 'min:12', 'max:13', 'regex:/^[A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3}$/i', Rule::unique('clientes', 'rfc')->withoutTrashed()],
            'observaciones'    => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required'             => 'El nombre es obligatorio.',
            'nombre.max'                  => 'El nombre no puede exceder los 100 caracteres.',
            'apellido_paterno.required'   => 'El apellido paterno es obligatorio.',
            'apellido_paterno.max'        => 'El apellido paterno no puede exceder los 100 caracteres.',
            'apellido_materno.max'        => 'El apellido materno no puede exceder los 100 caracteres.',
            'telefono.max'                => 'El teléfono no puede exceder los 20 caracteres.',
            'email.email'                 => 'El correo electrónico no tiene un formato válido.',
            'email.max'                   => 'El correo electrónico no puede exceder los 180 caracteres.',
            'email.unique'                => 'El correo electrónico ya está registrado.',
            'rfc.min'                     => 'El RFC debe tener al menos 12 caracteres.',
            'rfc.max'                     => 'El RFC no puede exceder los 13 caracteres.',
            'rfc.regex'                   => 'El RFC no tiene un formato válido.',
            'rfc.unique'                  => 'El RFC ya está registrado.',
            'observaciones.max'           => 'Las observaciones no pueden exceder los 1000 caracteres.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre'           => 'nombre',
            'apellido_paterno' => 'apellido paterno',
            'apellido_materno' => 'apellido materno',
            'telefono'         => 'teléfono',
            'email'            => 'correo electrónico',
            'rfc'              => 'RFC',
            'observaciones'    => 'observaciones',
        ];
    }
}

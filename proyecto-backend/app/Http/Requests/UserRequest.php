<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store User Request",
 *      required={"name,email,password"},
 *      description="Store User request body data",
 *      @OA\Xml(name="UserRequest"),
 * )
 */
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     *
     * * @OA\Property(
     *      property = "name",
     *      title="name",
     *      description="nombre del usuario",
     *      example="swaggerUser"
     * ),
     *
     * @var string
     * @OA\Property(
     *      property = "email",
     *      title="email",
     *      description="email del usuario",
     *      example="swaggerUser@email.com"
     * ),
     *
     * @var string
     * @OA\Property(
     *      property = "password",
     *      title="password",
     *      description="password del usuario",
     *      example="12345678"
     * ),
     *
     * @var string
     * @OA\Property(
     *      property = "password_confirmation",
     *      title="password_confirmation",
     *      description="confirmacion del password del usuario",
     *      example="12345678"
     * ),
     *
     * @var string
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = 'required|min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El campo nombre debe contener al menos 5 caracteres',
            'email.required' => 'El campo correo electrónico es requerido',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo válida',
            'password.required' => 'El campo contraseña es requerido',
            'password.min' => 'El campo contraseña debe contener al menos 8 caracteres',
            'password.confirmed' => 'El campo :attribute no coincide con la confirmación.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Category Request",
 *      required={"name,description"},
 *      description="Store Category request body data",
 *      @OA\Xml(name="CategoryRequest"),
 * )
 */
class CategoryRequest extends FormRequest
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
     * @OA\Property(
     *      property = "name",
     *      title="name",
     *      description="Nombre de la categoría",
     *      example="Portátiles"
     * ),
     *
     * @var string
     *
     * @OA\Property(
     *      property = "description",
     *      title="description",
     *      description="Descripción de la categoría",
     *      example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
     * ),
     *
     * @var string
     *
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:5',
            'description' => 'required|min:10',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.min' => 'El campo nombre debe tener al menos :min caracteres.',
            'description.required' => 'El campo descripción es obligatorio.',
            'description.min' => 'El campo descripción debe tener al menos :min caracteres.',
        ];
    }
}

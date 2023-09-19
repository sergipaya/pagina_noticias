<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Article Request",
 *      required={"title,description,body,image,categories,user_id"},
 *      description="Store Article request body data",
 *      @OA\Xml(name="ArticleRequest"),
 * )
 */
class ArticleRequest extends FormRequest
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
     *      property = "title",
     *      title="title",
     *      description="titulo de la noticia",
     *      example="noticia 1"
     * ),
     *
     * @var string
     *
     * @OA\Property(
     *      property = "description",
     *      title="description",
     *      description="descripcion de la noticia a mostrar brevemente",
     *      example="noticia sobre..."
     * ),
     *
     * @var string
     * @OA\Property(
     *      property = "body",
     *      title="body",
     *      description="cuerpo de la noticia",
     *      example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
     * ),
     *
     * @var string
     * @OA\Property(
     *      property = "categories",
     *      title="categories",
     *      description="array con las categorias a las que pertenece la noticia",
     *      example={"1", "2", "3"}
     * ),
     *
     * @var string
     * @OA\Property(
     *      property = "user_id",
     *      title="user_id",
     *      description="id del usuario que ha creado la noticia",
     *      example="1"
     * ),
     *
     * @var integer
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'body' => 'required|min:50',
            'categories' => 'required|exists:categories,id',
	   // 'image' => 'required|image'
        ];

        if ($this->method() == 'POST') {
            $rules['user_id'] = 'required|numeric';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'El campo título es obligatorio.',
            'title.min' => 'El campo título debe tener al menos :min caracteres.',
            'description.required' => 'El campo descripción es obligatorio.',
            'description.min' => 'El campo descripción debe tener al menos :min caracteres.',
            'body.required' => 'El campo contenido es obligatorio.',
            'body.min' => 'El campo contenido debe tener al menos :min caracteres.',
            'categories.required' => 'Se debe seleccionar al menos una categoría',
            'categories.exists' => 'La categoría no existe',
           // 'image.required' => 'Has de muntar una imatge',
        ];
    }
}

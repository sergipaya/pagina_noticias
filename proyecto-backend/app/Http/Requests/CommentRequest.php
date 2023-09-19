<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Comment Request",
 *      required={"body,article_id"},
 *      description="Store Comment request body data",
 *      @OA\Xml(name="CommentRequest"),
 * )
 */
class CommentRequest extends FormRequest
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
     *      property = "body",
     *      title="body",
     *      description="cuerpo del comentario",
     *      example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
     * ),
     *
     * @var string
     *
     * @OA\Property(
     *      property = "article_id",
     *      title="article_id",
     *      description="id de la noticia a la que pertenece",
     *      example="1"
     * ),
     *
     * @var integer
     *
     */
    public function rules(): array
    {
        $rules = [
            'body' => 'required|min:25',
        ];

        if ($this->method() == 'POST') {
            $rules['article_id'] = 'required|numeric|exists:news,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'body.required' => 'El campo contenido es obligatorio.',
            'body.min' => 'El campo contenido debe tener al menos :min caracteres.',
        ];
    }
}

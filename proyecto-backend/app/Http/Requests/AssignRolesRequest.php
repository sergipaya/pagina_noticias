<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store User Request",
 *      required={"roles"},
 *      description="Store AssignRoles request body data",
 *      @OA\Xml(name="AssignRolesRequest"),
 * )
 */
class AssignRolesRequest extends FormRequest
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
     *      property = "roles",
     *      title="roles",
     *      description="array con los roles del usuario",
     *      example={"1", "2"}
     * ),
     *
     * @var string
     */
    public function rules(): array
    {
        return [
            'roles' => 'required|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'roles.required' => 'Debes seleccionar al menos un rol.',
            'roles.exists' => 'La id de rol no existe',
        ];
    }
}

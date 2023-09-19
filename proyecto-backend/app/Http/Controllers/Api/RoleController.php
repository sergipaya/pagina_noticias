<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/roles",
     *      operationId="getRolesList",
     *      tags={"Roles"},
     *      summary="Muestra un listado de roles",
     *      description="Devuelve un listado de roles",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RoleResource")
     *       ),
     *     )
     */
    public function index()
    {
        return response()->json(RoleResource::collection(Role::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     ** @OA\Get(
     *      path="/api/roles/{role}",
     *      operationId="getRole",
     *      tags={"Roles"},
     *      summary="obtiene un rol",
     *      description="devuelve un rol",
     *      @OA\Parameter(
     *          name="role",
     *          description="id del rol a mostrar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RoleResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function show(Role $role)
    {
        return response()->json(new RoleResource($role));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}

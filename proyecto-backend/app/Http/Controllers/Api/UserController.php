<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRolesRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/api/users",
     *      operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Muestra un listado de usuarios",
     *      description="Devuelve un listado de usuarios",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *       ),
     *     )
     */
    public function index()
    {
        return response()->json(UserResource::collection(User::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/users",
     *      operationId="addUser",
     *      tags={"Users"},
     *      summary="añade un usuario",
     *      description="devuelve los datos de un usuario",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->roles()->attach(1);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/users/{user}",
     *      operationId="getUser",
     *      tags={"Users"},
     *      summary="obtiene un usuario",
     *      description="devuelve un usuario",
     *      @OA\Parameter(
     *          name="user",
     *          description="id del usuario a mostrar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/api/users/{user}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Edita un usuario",
     *      description="devuelve los datos de un usuario",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"ownUserOrAdmin":{}}},
     *      @OA\Parameter(
     *          name="user",
     *          description="Identificador del recurso",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *           @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Usuario no autenticado"))
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function update(UserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json($user, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/api/users/{user}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Borra un usuario",
     *      description="Borra un usuario y devuelve un 204",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"admin":{}}},
     *      @OA\Parameter(
     *          name="user",
     *          description="Identificador del recurso",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *           @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Usuario no autenticado"))
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json($user, 204);
    }

    /**
     * Assign roles to an user.
     *
     * @OA\Put(
     *      path="/api/assign_roles/{user}",
     *      operationId="updateAssignRoles",
     *      tags={"AssignRoles"},
     *      summary="asigna roles a un usuario",
     *      description="devuelve los roles de un usuario",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"admin":{}}},
     *      @OA\Parameter(
     *          name="user",
     *          description="Identificador del recurso",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AssignRolesRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *           @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Usuario no autenticado"))
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function assignRolesToUser(AssignRolesRequest $request, User $user)
    {
        $user->roles()->detach();
        $rolesToAdd = [];
        foreach ($request->roles as $role) {
            if (!in_array($role, $rolesToAdd)) {
                array_push($rolesToAdd, $role);
            }
        }
        $user->roles()->attach($rolesToAdd);
        return response()->json($user->roles, 201);
    }
}

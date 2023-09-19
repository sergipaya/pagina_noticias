<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/api/categories",
     *      operationId="getCategoriesList",
     *      tags={"Categories"},
     *      summary="Muestra un listado de categorías",
     *      description="Devuelve un listado de categorías",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *       ),
     *     )
     */
    public function index()
    {
        return response()->json(CategoryResource::collection(Category::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/categories",
     *      operationId="addCategory",
     *      tags={"Categories"},
     *      summary="añade una categoria",
     *      description="devuelve los datos de una categoria",
     *      security={ {"apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
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
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/categories/{category}",
     *      operationId="getCategory",
     *      tags={"Categories"},
     *      summary="obtiene una categoria",
     *      description="devuelve una categoria",
     *      @OA\Parameter(
     *          name="category",
     *          description="id de la categoria a mostrar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function show(Category $category)
    {
        return response()->json(new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/api/categories/{category}",
     *      operationId="updateCategory",
     *      tags={"Categories"},
     *      summary="Edita una categoria",
     *      description="devuelve los datos de una categoria",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"admin":{}}},
     *      @OA\Parameter(
     *          name="category",
     *          description="Identificador del recurso",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
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
    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/api/categories/{category}",
     *      operationId="deleteCategory",
     *      tags={"Categories"},
     *      summary="Borra una categoria",
     *      description="Borra una categoria y devuelve un 204",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"admin":{}}},
     *      @OA\Parameter(
     *          name="category",
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
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json($category, 204);
    }
}

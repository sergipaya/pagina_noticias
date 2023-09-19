<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/api/news",
     *      operationId="getArticlesList",
     *      tags={"Articles"},
     *      summary="Muestra un listado de noticias",
     *      description="Devuelve un listado de noticias",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *       ),
     *     )
     */
    public function index()
    {
        return response()->json(ArticleResource::collection(Article::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/news",
     *      operationId="addArticle",
     *      tags={"Articles"},
     *      summary="añade una noticia",
     *      description="devuelve los datos de una noticia",
     *      security={{"apiAuth":{}}, {"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ArticleRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Article")
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
    public function store(ArticleRequest $request)
    {
        $article = new Article();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->body = $request->body;
        $article->user_id = $request->user_id;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $destinationPath = 'storage/img';
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = $request->title . '.' . $extension;
                $request->file('image')->move($destinationPath, $fileName);
                $article->imageName = $filename;
        } else {
		$article->imageName = 'default.png';
	}

        $article->save();
        $article->categories()->detach();
        $this->addCategories($request, $article);

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/news/{article}",
     *      operationId="getArticle",
     *      tags={"Articles"},
     *      summary="obtiene una noticia",
     *      description="devuelve una noticia",
     *      @OA\Parameter(
     *          name="article",
     *          description="id de la noticia a mostrar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function show(Article $article)
    {
        return response()->json(new ArticleResource($article));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/api/news/{article}",
     *      operationId="updateArticle",
     *      tags={"Articles"},
     *      summary="Edita una noticia",
     *      description="devuelve los datos de una noticia",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"admin":{}}},
     *      @OA\Parameter(
     *          name="article",
     *          description="Identificador del recurso",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ArticleRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Article")
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
    public function update(ArticleRequest $request, Article $article)
    {
        $article->title = $request->title;
        $article->description = $request->description;
        $article->body = $request->body;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $destinationPath = 'storage/img';
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = $request->title . '.' . $extension;
                $request->file('image')->move($destinationPath, $fileName);
                $article->imageName = $filename;
        } else {
		$article->imageName = 'default.png';
	}


        $article->save();
        $article->categories()->detach();
        $this->addCategories($request, $article);

        return response()->json($article, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/api/news/{article}",
     *      operationId="deleteArticle",
     *      tags={"Articles"},
     *      summary="Borra una noticia",
     *      description="Borra una noticia y devuelve un 204",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"admin":{}}},
     *      @OA\Parameter(
     *          name="article",
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
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json($article, 204);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/news/category/{category}",
     *      operationId="getArticlesByCategory",
     *      tags={"Articles"},
     *      summary="Muestra un listado de noticias",
     *      description="Devuelve un listado de noticias",
     *      @OA\Parameter(
     *          name="category",
     *          description="id de la categoria a mostrar nosticias",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function getByCategory(Category $category): \Illuminate\Http\JsonResponse
    {
        return response()->json(ArticleResource::collection($category->news()->get()));
    }

    private function addCategories(ArticleRequest $request, Article $article): void
    {
        $categoriesToAdd = [];
        foreach ($request->categories as $category) {
            if (!in_array($category, $categoriesToAdd)) {
                array_push($categoriesToAdd, $category);
            }
        }
        $article->categories()->attach($categoriesToAdd);
    }
}

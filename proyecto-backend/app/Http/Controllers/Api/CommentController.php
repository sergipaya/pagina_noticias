<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/api/comments",
     *      operationId="getCommentsList",
     *      tags={"Comments"},
     *      summary="Muestra un listado de comentarios",
     *      description="Devuelve un listado de comentarios",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CommentResource")
     *       ),
     *     )
     */
    public function index()
    {
        return response()->json(CommentResource::collection(Comment::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/comments",
     *      operationId="addComment",
     *      tags={"Comments"},
     *      summary="añade un comentario",
     *      description="devuelve los datos de un comentario",
     *      security={ {"apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CommentRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
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
    public function store(CommentRequest $request)
    {
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = auth()->id();
        $comment->article_id = $request->article_id;
        $comment->save();

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/comments/{comment}",
     *      operationId="getComment",
     *      tags={"Comments"},
     *      summary="obtiene un comentario",
     *      description="devuelve un comentario",
     *      @OA\Parameter(
     *          name="comment",
     *          description="id del comentario a mostrar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CommentResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function show(Comment $comment)
    {
        return response()->json(new CommentResource($comment));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/api/comments/{comment}",
     *      operationId="updateComment",
     *      tags={"Comments"},
     *      summary="Edita un comentario",
     *      description="devuelve los datos de un comentario",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"commentOwnerOrAdmin":{}}},
     *      @OA\Parameter(
     *          name="comment",
     *          description="Identificador del recurso",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CommentRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
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
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->body = $request->body;
        $comment->save();

        return response()->json($comment, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/api/comments/{comment}",
     *      operationId="deleteComment",
     *      tags={"Comments"},
     *      summary="Borra un comentario",
     *      description="Borra un comentario y devuelve un 204",
     *      security={{"apiAuth":{}}, {"sanctum":{}}, {"commentOwnerOrAdmin":{}}},
     *      @OA\Parameter(
     *          name="comment",
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
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json($comment, 204);
    }
}

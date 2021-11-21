<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Recipe;

class CommentController extends Controller
{
    public function index(Recipe $recipe)
    {
        return CommentResource::collection($recipe->comments()->orderBy('created_at', 'DESC')->get());
    }

    public function store(CommentStoreRequest $request, Recipe $recipe)
    {
        $comment = array_merge($request->validated(), ['user_id' => auth()->user()->id]);
        $recipe->comments()->create($comment);

        return response(['message' => 'success']);
    }

    public function update(CommentUpdateRequest $request, Recipe $recipe, Comment $comment)
    {
        $comment->update($request->validated());

        return response(['message' => 'success']);
    }

    public function destroy(Comment $comment)
    {
        //
    }
}

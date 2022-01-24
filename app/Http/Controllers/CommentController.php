<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\DeleteCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function show()
    {
        return CommentResource::collection(Comment::whereNull('parent_id')->get());
    }

    public function replies()
    {
        return CommentResource::collection(
            Comment::where('parent_id', request()->route('id'))->get()
        );
    }

    public function create(CreateCommentRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();

        /** @var User $user */
        $user = Auth::user();

        Comment::create([
            'parent_id' => $validatedData['reply_to'],
            'comment' => $validatedData['comment'],
            'user_id' => $user->id
        ]);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function delete(DeleteCommentRequest $request): JsonResponse
    {
        $commentId = $request->safe()->all()['id'];

        if (Comment::destroy($commentId)) {
            return response()->json(status: Response::HTTP_NO_CONTENT);
        }

        abort(403);
    }
}

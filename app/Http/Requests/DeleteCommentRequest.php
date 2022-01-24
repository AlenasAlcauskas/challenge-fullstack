<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class DeleteCommentRequest extends FormRequest
{
    public function authorize()
    {
        $comment = Comment::find($this->route('id'));

        return $this->user()->can('delete', $comment);
    }

    public function all($keys = null): array
    {
        return ['id' => $this->route('id')];
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:comments,id'
        ];
    }

    public function messages(): array
    {
        return [
            'id.exists' => 'Incorrect comment id',
        ];
    }
}

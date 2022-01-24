<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'comment' => 'required|min:1|max:200',
            'reply_to' => 'sometimes|nullable|exists:comments,id'
        ];
    }

    public function messages(): array
    {
        return [
            'reply_to.exists' => 'Incorrect reply',
        ];
    }
}

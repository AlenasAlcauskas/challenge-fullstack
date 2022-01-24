<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'name' => $this->resource->user->name,
            'picture' => $this->resource->userPicture(),
            'text' => $this->resource->comment,
            'time' => $this->resource->getFormattedDate(),
            'repliesCount' => $this->resource->repliesCount()
        ];
    }
}

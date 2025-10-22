<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "image" => url($this->image),
            "liked_it" => false,
            "count_likes" => $this->likes()->count(),
            "post_maker_id" => $this->user_id,
            "created_at" => Carbon::make($this->created_at)->format("Y-m-d"),
        ];
    }
}

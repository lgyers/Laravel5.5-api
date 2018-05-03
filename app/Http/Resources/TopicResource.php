<?php

namespace App\Http\Resources;

use App\Models\Topic;
use Illuminate\Http\Resources\Json\Resource;

class TopicResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'title'              => $this->title,
            'body'               => $this->body,
            'user_id'            => (int) $this->user_id,
            'category_id'        => (int) $this->category_id,
            'reply_count'        => (int) $this->reply_count,
            'view_count'         => (int) $this->view_count,
            'last_reply_user_id' => (int) $this->last_reply_user_id,
            'excerpt'            => $this->excerpt,
            'slug'               => $this->slug,
            'created_at'         => $this->created_at->toDateTimeString(),
            'updated_at'         => $this->updated_at->toDateTimeString(),
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Models\Reply;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Resources\ReplyRresource;

class RepliesController extends ApiController
{
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
    	$reply->content = $request->content;
    	$reply->topic_id = $topic->id;
    	$reply->user_id = \Auth::guard('api')->user()->id;
    	$reply->save();

    	return $this->success(new ReplyRresource($reply));
    }
}

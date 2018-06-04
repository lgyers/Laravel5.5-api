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

    public function destroy(Topic $topic, Reply $reply)
    {
    	if ($reply->topic_id != $topic->id) {
            return $this->failed('BadRequest');
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        return $this->status('删除成功', [], 204);
    }

    public function index(Topic $topic)
    {
    	$replies = $topic->replies()->paginate(20);

    	return $this->success(new ReplyRresource($replies));
    }
}

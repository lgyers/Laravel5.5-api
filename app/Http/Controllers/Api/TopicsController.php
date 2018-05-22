<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;

class TopicsController extends ApiController
{
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = \Auth::guard('api')->user()->id;
        $topic->save();

        return $this->created(new TopicResource($topic));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
    	$this->authorize('update', $topic);

	    $topic->update($request->all());
	    return $this->success(new TopicResource($topic));
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->delete();
        return $this->message('删除成功');
    }
}

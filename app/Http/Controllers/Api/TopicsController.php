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

    public function index(Request $request, Topic $topic)
    {
        $query = $topic->query();

        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }
        switch ($request->order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        $topics = $query->paginate(20);

        return $this->success(new TopicResource($topics));
    }
}

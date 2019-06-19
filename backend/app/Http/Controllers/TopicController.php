<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request; // Si no lo usas lo comentas
use App\Post;
use App\Topic;
use App\Http\Resources\Topic as TopicResource;
use App\Http\Requests\TopicCreateRequest;
use App\Http\Requests\UpdateTopicRequest;

class TopicController extends Controller {

    public function index() {
        // en lugar de get() puedes usar ->paginate(5) para ayudar al frontend con la paginacion (checa en la respuesta "links")
        //$topics = Topic::latestFirst()->get();
        $topics = Topic::latestFirst()->paginate(5);
        return TopicResource::collection($topics);
    }


    public function store(TopicCreateRequest $request) {
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return new TopicResource($topic);
    }

    public function show(Topic $topic) {
        return new TopicResource($topic);
    }

    public function update(UpdateTopicRequest $request, Topic $topic) {
        $this->authorize('update', $topic); // Applying policy update
        $topic->title = $request->get('title', $topic->title);
        $topic->save();
        return new TopicResource($topic);
    }

    public function destroy(Topic $topic) {
        $this->authorize('destroy', $topic);
        $topic->delete();
        return response(null, 204);
    }
}

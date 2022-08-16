<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Traits\GlobalTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    use GlobalTraits;

    public function getAllPost()
    {

        $posts = PostResource::collection(Post::all());

        return $this->SendResponse($posts, "success gat all posts", 200);
    }

    public function getSinglePost($id)
    {

        $post = Post::find($id);

        if ($post) {
            return $this->SendResponse(new PostResource($post), "success gat Single posts", 200);
        } else {
            return $this->SendResponse(null, "error Tha post not found", 401);
        }
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:10',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->SendResponse(null, $validator->errors(), 400);
        }

        $post = Post::create($request->all());

        if ($post) {
            return $this->SendResponse(new PostResource($post), $validator, 201);
        }
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:10',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->SendResponse(null, $validator->errors(), 400);
        }

        $post = Post::find($id);

        if (!$post) {
            return $this->SendResponse(null, "Error tha post is notfound", 404);
        }

        $post->update($request->all());

        if ($post) {
            return $this->SendResponse(new PostResource($post), "success update tha post", 201);
        }
    }

    public function destroy($id){

        $post = Post::find($id);
        if (!$post) {
            return $this->SendResponse(null, "Error tha post was deleted before", 404);
        }
        $post->delete();

        if ($post) {
            return $this->SendResponse(null, "success Deleted tha post", 200);
        }

    }
}

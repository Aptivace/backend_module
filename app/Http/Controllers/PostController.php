<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()->whereHas('user', fn ($query) => $query->where('is_banned', false))->get();
        return response()->json(PostResource::collection($posts), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "title" => "required|string",
            "description" => "nullable|string",
            "image"=> "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4608",
        ]);
        if ($validator->fails()) {
            return $this->errors(errors: $validator->errors());
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id();

        $img = $request->image;

        if ($img) {
            $url = Str::uuid() . "." . $img->getClientOriginalExtension();
            $img->move(public_path("posts"), $url);
            $data['image'] = 'posts/' . $url;
        }
        $post = Post::query()->create($data);
        return response()->json(PostResource::make($post), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(["message"=>"GET OUT!!", "error_code"=>"4444" ], 403);
        }
        $validator = validator($request->all(), [
            "title" => "required|string",
            "description" => "nullable|string",
            "image"=> "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4608",
        ]);
        if ($validator->fails()) {
            return $this->errors(errors: $validator->errors());
        }

        $data = $validator->validated();

        $img = $request->image;

        if ($img) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }

            $url = Str::uuid() . "." . $img->getClientOriginalExtension();
            $img->move(public_path("posts"), $url);
            $data['image'] = 'posts/' . $url;
        }
        $post->update($data);
        return response()->json(PostResource::make($post), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(["message"=>"GET OUT!!", "error_code"=>"4444" ], 403);
        }
        $post->delete();
        return response()->nocontent();
    }
}

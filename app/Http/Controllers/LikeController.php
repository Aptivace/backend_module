<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Post $post )
    {
        if (Like::query()->where('post_id', $post->id)->where('user_id', Auth::id())->exists()) {
            return response()->json(["error"=>["message"=>"There’s already a like"]], 403);
        }
        Like::query()->create([
            "user_id" => auth()->id(),
            "post_id" => $post->id,
        ]);
        return response()->json(["data"=>["message"=>"success"]]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $like = Like::query()->where('post_id', $post->id)->where('user_id', Auth::id())->first();
        if (!$like) {
            return response()->json(["error"=>["message"=>"There’s already a like"]], 403);
        }
        $like->delete();
        return response()->json(["data"=>["message"=>"success"]]);
    }
}

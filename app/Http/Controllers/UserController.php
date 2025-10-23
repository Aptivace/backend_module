<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user)
    {
        if ($user->is_banned) {
            return $this->errors(message: "User has been banned", status: 404);
        }
        if ($user->role == 'admin') {
            return $this->errors(message: "Not found", status: 404);
        }
        $posts = Post::query()
            ->where('user_id', $user->id)
            ->paginate(10);
        return response()->json(["data" => [
            "nickname" => $user->nickname,
            "posts" => PostResource::collection($posts)
        ]]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            "email" => "required|email",
            "password" => "required|string",
        ]);
        if ($validator->fails()) return $this->errors(errors: $validator->errors());
        if (!auth()->attempt($request->only("email", "password"))) {
            return $this->errors(message: "failed", status: 401);
        }
        $user = auth()->user();
        $token = Str::uuid();
        $user->update(["token" => $token]);
        return response()->json([
            "credentials" => ["token" => $token],
        ], status: 200);
    }

    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            "nickname" => "required|string|max:20",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:3",
        ]);
        if ($validator->fails()) {
            return $this->errors(errors: $validator->errors());
        }
        $user = User::query()->create($validator->validated());
        return response()->json(["data" => ["user" => ["nickname" => $user->nickname, "email" => $user->email]]], status: 201);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->update(["token" => null]);
        return response()->nocontent();
    }
}

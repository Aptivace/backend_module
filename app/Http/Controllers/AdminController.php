<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user && $user->role == "admin") {
            $query = User::query();

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nickname', 'like', '%' . $search . '%');
                });
            }

            $users_list = $query->get();
            return view('users', compact('users_list'));
        }
        return view('login');
    }

    public function update(User $user)
    {
        if ($user->is_banned) {
            $user->update(['is_banned' => false]);
        } else {
            $user->update(['is_banned' => true]);
        }

        return redirect('/admin');
    }

    public function login()
    {
        $validator = validator(request()->all(), [
            "email" => "required",
            "password" => "required"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        if (!auth()->attempt($validator->validated())) {
            return back()->withErrors(["error" => "Не верный логин или пароль"]);
        }
        $user = auth()->user();

        if ($user->role !== "admin") {
            return back()->withErrors(["error" => "Вы не админ"]);
        }
        return view('users');

    }

    public function logout()
    {
        auth()->logout();
        return back();
    }

}

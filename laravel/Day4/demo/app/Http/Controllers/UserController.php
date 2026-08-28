<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show(string $id)
    {
        $user = User::with('orders.orderItems.product')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return to_route('users.index');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;

class WelcomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('welcome', compact('categories'));
    }
}

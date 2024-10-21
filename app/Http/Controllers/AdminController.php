<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin', compact('posts'));
    }

    public function toggleVisibility(Request $request, Post $post) {
        $post->is_visible = !$post->is_visible;
        $post->save();

        return redirect()->route('admin');
    }
}

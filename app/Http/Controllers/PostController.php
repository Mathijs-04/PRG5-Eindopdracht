<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        return view('posts', compact('posts'));
    }

    public function show($id) {
        $post = Post::find($id);
        return view('show', compact('id'));
    }
}

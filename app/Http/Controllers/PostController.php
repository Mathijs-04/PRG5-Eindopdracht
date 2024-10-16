<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        return view('posts', compact('posts'));
    }

    public function show($id) {
        $post = Post::find($id);
        return view('show', compact('post'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post();

        $post->user_id = auth()->id();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->image_url = $request->input('image_url');
        $post->tag = $request->input('tag');
        $post->is_visible = 1;
        $post->created_at = Date::now();
        $post->updated_at = Date::now();

        $post->save();

        return redirect(route('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}

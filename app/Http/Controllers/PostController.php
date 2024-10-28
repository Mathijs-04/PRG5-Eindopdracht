<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request) {
        $sort = $request->input('sort', 'date_desc');
        $postsQuery = Post::with('likes');

        if ($sort === 'date_asc') {
            $postsQuery->orderBy('created_at', 'asc');
        } elseif ($sort === 'likes_desc') {
            $postsQuery->withCount('likes')->orderBy('likes_count', 'desc');
        } elseif ($sort === 'likes_asc') {
            $postsQuery->withCount('likes')->orderBy('likes_count', 'asc');
        } else {
            $postsQuery->orderBy('created_at', 'desc');
        }

        $posts = $postsQuery->get();
        foreach ($posts as $post) {
            $post->likeCount = $post->likes->count();
        }

        $isSearchResult = false;
        $errorMessage = $posts->isEmpty() ? 'No posts found' : null;
        return view('posts', compact('posts', 'errorMessage', 'isSearchResult'));
    }

    public function show($id) {
        $post = Post::with('user')->findOrFail($id);
        $likeCount = $post->likes()->count();
        $existingLike = auth()->user() ? $post->likes()->where('user_id', auth()->id())->first() : null;
        return view('show', compact('post', 'likeCount', 'existingLike'));
    }

    public function create() {
        $userLikeCount = $this->userLikeCount();
        $allowedToPost = $userLikeCount >= 5;
        return view('posts.create', compact('allowedToPost'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:35',
            'description' => 'required|max:2000',
            'tag' => 'required|in:Warhammer 40K,Warhammer AOS,GW Middle Earth,Dungeons & Dragons,Other',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->image_url = $request->input('image_url');
        $post->image = 'images/' . $imageName;
        $post->tag = $request->input('tag');
        $post->is_visible = 1;
        $post->created_at = now();
        $post->updated_at = now();

        $post->save();

        return redirect()->route('posts');
    }

    public function edit($id) {
        $post = Post::findOrFail($id);
        return view('edit', compact('post'));
    }

    public function update(Request $request, Post $post) {
        $request->validate([
            'title' => 'required|max:35',
            'description' => 'required|max:2000',
            'tag' => 'required|in:Warhammer 40K,Warhammer AOS,GW Middle Earth,Dungeons & Dragons,Other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image = 'images/' . $imageName;
        }

        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->image_url = $request->input('image_url');
        $post->tag = $request->input('tag');
        $post->updated_at = now();

        $post->save();

        return redirect()->route('posts');
    }

    public function destroy(Post $post) {
        $post->delete();
        return redirect()->route('posts');
    }

    public function search(Request $request) {
        $searchQuery = $request->input('search');
        $selectedTag = $request->input('tag');

        $posts = Post::where(function ($query) use ($searchQuery) {
            $query->where('title', 'LIKE', "%{$searchQuery}%")
                ->orWhere('description', 'LIKE', "%{$searchQuery}%");
        })
            ->when($selectedTag, function ($query) use ($selectedTag) {
                return $query->where('tag', $selectedTag);
            })
            ->where('is_visible', 1)
            ->with('likes')
            ->get()
            ->each(function ($post) {
                $post->likeCount = $post->likes->count();
            });

        $errorMessage = $posts->isEmpty() ? 'No search results' : null;
        $isSearchResult = true;

        return view('posts', compact('posts', 'errorMessage', 'isSearchResult'));
    }

    public function like(Post $post) {
        $user = Auth::user();

        $existingLike = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }

        return redirect()->route('show', $post->id);
    }

    public function userLikeCount() {
        return Like::where('user_id', auth()->id())->count();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //Toont alle posts en regelt sortering
    public function index(Request $request) {
        //Standaard sorteren op nieuwste
        $sort = $request->input('sort', 'date_desc');
        //Posts met likes ophalen
        $postsQuery = Post::with('likes');
        //Posts sorteren op basis van selectie
        if ($sort === 'date_asc') {
            $postsQuery->orderBy('created_at', 'asc');
        } elseif ($sort === 'likes_desc') {
            $postsQuery->withCount('likes')->orderBy('likes_count', 'desc');
        } elseif ($sort === 'likes_asc') {
            $postsQuery->withCount('likes')->orderBy('likes_count', 'asc');
        } else {
            $postsQuery->orderBy('created_at', 'desc');
        }
        //Iedere post met individuele likes tonen
        $posts = $postsQuery->get();
        foreach ($posts as $post) {
            $post->likeCount = $post->likes->count();
        }
        //Standaard geen zoekresultaat
        $isSearchResult = false;
        //Error indien geen zoekresultaten
        $errorMessage = $posts->isEmpty() ? 'No posts found' : null;
        //View tonen met alle data
        return view('posts', compact('posts', 'errorMessage', 'isSearchResult'));
    }

    //Toont detailweergave van een post
    public function show($id) {
        //Post en het gekoppelde user_id ophalen
        $post = Post::with('user')->findOrFail($id);
        //Likes van de post ophalen
        $likeCount = $post->likes()->count();
        //Check of de huidige user de post een like heeft gegeven
        $existingLike = auth()->user() ? $post->likes()->where('user_id', auth()->id())->first() : null;
        //View tonen met alle data
        return view('show', compact('post', 'likeCount', 'existingLike'));
    }

    //Toont create-pagina indien user mag posten
    public function create() {
        //Haalt de gegeven likes op
        $userLikeCount = $this->userLikeCount();
        //User mag posten na vijf likes
        $allowedToPost = $userLikeCount >= 5;
        //View tonen met of zonder toestemming
        return view('posts.create', compact('allowedToPost'));
    }

    //Valideert data van create en slaat deze op
    public function store(Request $request) {
        //Valideer de data uit de form
        $request->validate([
            'title' => 'required|max:35',
            'description' => 'required|max:2000',
            'tag' => 'required|in:Warhammer 40K,Warhammer AOS,GW Middle Earth,Dungeons & Dragons,Other',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        //Geef de afbeelding een naam
        $imageName = time() . '.' . $request->image->extension();
        //Sla de afbeelding op in de images folder in public
        $request->image->move(public_path('images'), $imageName);
        //Sla een nieuwe post op in de database en vul alle kolommen
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
        //Sla de post op in de database
        $post->save();
        //Stuur de user terug naar de posts pagina
        return redirect()->route('posts');
    }

    //Toont edit-pagina indien user eigenaar of admin is
    public function edit($id) {
        //Haal het post_id op
        $post = Post::findOrFail($id);
        //Check of de user eigenaar of admin is
        if (auth()->check() && (auth()->user()->is_admin || auth()->user()->id === $post->user_id)) {
            //Toon de view
            return view('edit', compact('post'));
        } else {
            //Redirect de user naar posts
            return redirect()->route('posts');
        }
    }

    //Valideert data van edit en slaat deze op
    public function update(Request $request, Post $post) {
        //Valideer de data uit de form
        $request->validate([
            'title' => 'required|max:35',
            'description' => 'required|max:2000',
            'tag' => 'required|in:Warhammer 40K,Warhammer AOS,GW Middle Earth,Dungeons & Dragons,Other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        //Als er al een image was, gebruik deze dan opnieuw
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image = 'images/' . $imageName;
        }
        //Vul de overige kolommen met de (nieuwe) data
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->image_url = $request->input('image_url');
        $post->tag = $request->input('tag');
        $post->updated_at = now();
        //Sla de post op in de database
        $post->save();
        //Stuur de user terug naar de posts pagina
        return redirect()->route('posts');
    }

    //Verwijderd de post indien user eigenaar of admin is
    public function destroy(Post $post) {
        //Check of de user eigenaar of admin is
        if (auth()->check() && (auth()->user()->is_admin || auth()->user()->id === $post->user_id)) {
            //Verwijder de post en stuur de user terug
            $post->delete();
            return redirect()->route('posts')->with('success', 'Post deleted successfully.');
        } else {
            //Verwijder de post niet en stuur de user terug
            return redirect()->route('posts')->with('error', 'You are not authorized to delete this post.');
        }
    }

    //Toont posts op basis van zoekopdracht
    public function search(Request $request) {
        //searchQuery is de string uit het search veld
        $searchQuery = $request->input('search');
        //selectedTag is de string uit de tag dropdown
        $selectedTag = $request->input('tag');
        //Haal alle posts op waarvan $searchQuery overeenkomt met de titel of beschrijving, indien er een query is
        $posts = Post::where(function ($query) use ($searchQuery) {
            $query->where('title', 'LIKE', "%{$searchQuery}%")
                ->orWhere('description', 'LIKE', "%{$searchQuery}%");
        })
            //Indien er een tag is geselecteerd, haal alle posts op met deze tag
            ->when($selectedTag, function ($query) use ($selectedTag) {
                return $query->where('tag', $selectedTag);
            })
            //Haal alleen zichtbare posts op
            ->where('is_visible', 1)
            //Haal ook de bijbehorende likes op
            ->with('likes')
            //Haal alle resultaten op en geef ze terug in een collectie
            ->get()
            //Toon iedere post met individuele likes
            ->each(function ($post) {
                $post->likeCount = $post->likes->count();
            });
        //Het gaat om een zoekresultaat
        $isSearchResult = true;
        //Error indien geen zoekresultaten
        $errorMessage = $posts->isEmpty() ? 'No search results' : null;
        //View tonen met alle data
        return view('posts', compact('posts', 'errorMessage', 'isSearchResult'));
    }

    //Maakt likes aan
    public function like(Post $post) {
        //Haalt de huidige user op
        $user = Auth::user();
        //Kijk of deze user deze post al een like heeft gegeven
        $existingLike = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();
        //Als er al een like is gegeven, haal deze dan weer weg
        if ($existingLike) {
            $existingLike->delete();
        //Als er geen like is gegeven, maak er dan een aan met user_id en post_id
        } else {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }
        //Stuur de user terug naar de detailpagina
        return redirect()->route('show', $post->id);
    }

    //Telt de likes van de user
    public function userLikeCount() {
        //Telt het aantal keer dat een user_id voorkomt in likes, wat wordt gebruikt in de create functie
        return Like::where('user_id', auth()->id())->count();
    }
}

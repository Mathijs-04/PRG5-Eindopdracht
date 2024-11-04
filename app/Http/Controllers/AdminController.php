<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //Checkt of de user admin is en toont de admin-pagina
    public function index() {
        //Check of de user admin is
        if (auth()->check() && auth()->user()->is_admin) {
            //Haal alle posts binnen en sorteer ze op aflopende datum
            $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
            //Toon de admin view met posts
            return view('admin', compact('posts'));
        } else {
            //Indien user geen admin is, stuur deze terug naar home
            return redirect()->route('home');
        }
    }

    //Schakelt de zichtbaarheid van posts via een form met POST-methode
    public function toggleVisibility(Request $request, Post $post) {
        //Wissel de zichtbaarheidsstatus van de post
        $post->is_visible = !$post->is_visible;
        //Sla de nieuwe status op in de database
        $post->save();
        //Stuur de admin terug naar de admin-pagina
        return redirect()->route('admin');
    }
}

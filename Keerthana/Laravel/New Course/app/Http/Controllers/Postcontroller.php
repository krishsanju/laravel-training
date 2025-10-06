<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Postcontroller extends Controller
{
    public function index(){
        $posts = Post::where('user_id',Auth::user()->id)->get();
        return view("post.index", compact('posts'));
    }

    public function edit(string $id){
        $post = Post::find($id);

        // if(!Gate::allows('update-post', $post)) abort(403);  //GATE
        Gate::authorize('update', $post);
        return view('post.edit', compact('post'));
    }
}

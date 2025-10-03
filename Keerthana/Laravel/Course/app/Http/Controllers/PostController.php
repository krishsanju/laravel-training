<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::all();
        // $posts = Post::orderBy('id', 'asc')->get();

        $posts = Post::latest(); //query scopes
        return view("posts.index", compact("posts"));
    }


    public function create()
    {
        // echo "HI This is create";
        return view("posts.create");
    }

    public function store(Request $request)
    {
        // echo "HI This is store";

        // Post::create($request->all());
        // return redirect("/posts");

        //other way
        // $post_instance = new Post();
        // $post_instance->title = $request->title;
        // $post_instance->content = $request->content;

        // $post_instance->save();


//file operations  // instead of CreatePostRequest give Request
        // $file = $request->file('fileToUpload');
        // echo '<br>';
        // echo $file->getClientOriginalName();
        // echo '<br>';
        // echo $file->getClientSize();

        $input = $request->all();
        if($file = $request->file("fileToUpload")){
            $name = $file->getClientOriginalName();
            // $file->move('images', $name);
            $input ['title'] = $name;
            $input ['content'] = 'ntg';
        }
        Post::create($input);


    }


}

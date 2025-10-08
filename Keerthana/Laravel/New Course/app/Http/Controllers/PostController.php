<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ViewPostResource;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function adminPosts(){
        $users = User::adminUser()->get();
        return ViewPostResource::collection($users)->resolve();
    }

    public function userPosts($id){
        $user = User::find($id);
        return response()->json([
            'user' => $user->name,
            'posts' => $user->posts,
        ]);
        
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){

        $user = User::find(4);

        $data = $request->all();
        $data['user_id'] = $user->id;
        $post = Post::createPost($data);
        
        Article::create([
            'post_id' => $post->id,  'description' => $request->description,
        ]);

        return response()->json([
            'status' => 'Success',
            'post' => $post,
            'article' => $post->article 
        ]); 
    }


    public function delete($id){
        $post = Post::find($id);
        if ($post){
            $post->delete();

            return response()->json([
                'status'=> 'Delete post and article associated with it',
                'post'=> $post,
            ]);
        }

        return response()->json( "Post not found" );
    }

    public function update($id, Request $request){
        $post = Post::find($id);
        
        if ($post){
            $post->update([
                'title' => $request->has('title') ? $request->title : $post->title,
                'image_path' => $request->has('image_path') ? $request->image_path : $post->image_path,
                'tags' => $request->has('tags') ? $request->tags : $post->tags
            ]);
            $post->article->update([
                'description' => $request->has('description') ? $request->description : $post->article->description
            ]);

            return response()->json([  "status"=> "Successfully updated ", ]);
        }else{
            return response()->json( "Post not found");  //api resourcse
        }
    }
}


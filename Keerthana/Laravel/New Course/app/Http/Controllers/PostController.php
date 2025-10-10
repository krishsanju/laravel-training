<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
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


    public function storePost(Request $request){
        $user = User::find(4);
        // $post = $user->posts()->createWithArticle($request->all());
        // // $post = Post::createWithArticle($request->all());
        $data = $request->all();
        $data['user_id'] = $user->id; 

        $post = Post::createWithArticle($data);
        return ApiResponse::setMessage($post, 'Post submitted successfully!')
                    ->mergeResponse($post->article)
                    ->send();
    }


    public function deletePost($id){
        $post = Post::find($id);
        if ($post){
            $post->delete();
            return ApiResponse::setMessage($post, 'Post and article associated with it are deleted');
        }

        return response()->json( "Post not found" );
    }

    public function updatePost($id, Request $request){
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
            // return response()->json( "Post not found");
            return ApiResponse::setMessage($post, 'Post not found!');
        }
    }
}


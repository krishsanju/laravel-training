<?php

namespace App\Http\Controllers;

// use GuzzleHttp\Middleware;

use App\Http\Middleware\CheckRoleMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller implements HasMiddleware
{

//before implementing other methods this method is implemented 
//it checks the middleware
    public static function middleware(): array   //static method in hasMiddleware interface  
    {
        return [new Middleware(CheckRoleMiddleware::class, except:['index'])];
    }

    public function index(){
        return view("post.index");
    }
    function handlePost(Request $request){
        dd($request->all());
    }
}

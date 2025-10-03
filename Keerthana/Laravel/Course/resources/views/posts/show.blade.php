@extends('layouts.app')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p> {{ $post->content }}</p>

    <small><a href="{{ route('posts.edit', $post->id) }}"> click this to edit  post</a></small>


    <form method ='post' action = "/posts/{{ $post->id }}">
        @csrf <!-- {{ csrf_field() }} -->
        
        @method('DELETE') 
        <small><a href="{{ route('posts.destroy', $post->id) }}"> delete post </a></small>
    </form>


@endsection

@section('footer')

@endsection
@extends('layouts.app')

@section('content')
    <form method = 'post' action="/posts/{{ $post->id }}">
        @csrf <!-- {{ csrf_field() }} -->

        @method('PUT')  <!-- <input type="hidden" name="_method" value="PUT"> -->

        <input type="text" name = 'title' placeholder="Enter title" value = "{{ $post->title }}"><br>
        <input type="text"  name='content' value = "{{ $post->content }}"><br>

        <input type="submit" name = 'submit'>
    </form>
@endsection
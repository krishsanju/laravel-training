@extends('layouts.app')

<!-- @section('content')
    <form method = 'post' action="/posts">
        @csrf {{ csrf_field() }}
        <input type="text" name = 'title' placeholder="Enter title"><br>
        <textarea  name="content" placeholder="Enter your content" rows="4" cols="50"></textarea><br>
        <input type="text"  name='content' ><br>
        <input type="submit" name = 'submit'>
    </form> -->


    <form action="/posts" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <input type="file" class="form-control-file" name="fileToUpload" id="exampleInputFile">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('footer')

@endsection
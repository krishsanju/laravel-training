<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Document</title>
    </head>
    <body>
        <form method="post" action="{{ route('post.handle') }}">
            @csrf
            <div>
                <input type="hidden" value="3" name ='user_id'> 
                <input type="text" name="title"><br>
                <textarea name="description"></textarea></textarea><br>
                <button type="submit">Submit</button>
            </div>
        </form>
    </body>
</html>
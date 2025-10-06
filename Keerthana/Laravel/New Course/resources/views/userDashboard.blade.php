<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3> User dashboard </h3>

     <p> Name: {{ Auth()->user()->name }}</p> <!-- auth is a helper function -->
     <p> Email: {{ auth()->user()->email }}</p>

     <!-- <a href="{{ route('logout') }}">Logout</a> -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">LOGOUT</button>
      </form>
</body>
</html>
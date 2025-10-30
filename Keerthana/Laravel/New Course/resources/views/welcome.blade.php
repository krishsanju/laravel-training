<!DOCTYPE html>
<html>
<head>
    <title>Login with Google</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="text-center p-5">

    @auth
        <h2>Welcome, {{ auth()->user()->name }}!</h2>
        <p>Email: {{ auth()->user()->email }}</p>
        <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
    @else
        <h1>Login with Google</h1>
        <a href="{{ url('auth/google') }}" class="btn btn-primary">Sign in with Google</a>
    @endauth

</body>
</html>

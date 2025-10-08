<form method="POST" action="{{ route('register.submit') }}">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" name="password">
    </div>

    <div>
        <label for="role">Role:</label>
        <input type="role" name="role">
    </div>

    <button type="submit">Register</button>
</form>

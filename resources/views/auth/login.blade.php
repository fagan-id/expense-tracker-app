<form action="{{ route('login.submit') }}" method="POST">
    @csrf
    <label>Username or Email :</label>
    <input type="text" name="identifier" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>

<a href="{{ route('register') }}">
    <button type="button">Register</button>
</a>


<h1>Ini Dashboard</h1>
<form action="{{ route('logout.submit') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

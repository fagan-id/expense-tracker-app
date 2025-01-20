<form action="{{ route('logout.submit') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

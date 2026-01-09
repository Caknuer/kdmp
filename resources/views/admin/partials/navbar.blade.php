<div style="padding:10px; background:#eee;">
    <strong>ADMIN KDMP</strong>

    <form method="POST" action="{{ route('admin.logout') }}" style="float:right;">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>

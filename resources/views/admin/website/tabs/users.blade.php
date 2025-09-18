<div class="tab-users-content">
    <h4>Users</h4>
    <form id="user-search-form" style="margin-bottom:1rem;">
        <input type="text" name="search" id="user-search" placeholder="Search users..." value="{{ request('search') }}" style="padding:6px 12px; border-radius:6px; border:1px solid #ccc;">
        <button type="submit" style="padding:6px 16px; border-radius:6px;">Search</button>
    </form>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <script>
    document.getElementById('user-search-form').onsubmit = function(e) {
        e.preventDefault();
        const search = document.getElementById('user-search').value;
        window.loadTabData('users', search);
    };
    </script>
</div>
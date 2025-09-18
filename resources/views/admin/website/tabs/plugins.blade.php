<div class="tab-plugins-content">
    <h4>Plugins</h4>
    <form id="plugin-search-form" style="margin-bottom:1rem;">
        <input type="text" name="search" id="plugin-search" placeholder="Search plugins..." value="{{ request('search') }}" style="padding:6px 12px; border-radius:6px; border:1px solid #ccc;">
        <button type="submit" style="padding:6px 16px; border-radius:6px;">Search</button>
    </form>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Version</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plugins as $plugin)
                <tr>
                    <td>{{ $plugin->name }}</td>
                    <td>{{ $plugin->version }}</td>
                    <td>{{ $plugin->status }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No plugins found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <script>
    document.getElementById('plugin-search-form').onsubmit = function(e) {
        e.preventDefault();
        const search = document.getElementById('plugin-search').value;
        window.loadTabData('plugins', search);
    };
    </script>
</div>
<div class="tab-themes-content">
    <h4>Themes</h4>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Version</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($themes as $theme)
                <tr>
                    <td>{{ $theme->name }}</td>
                    <td>{{ $theme->version }}</td>
                    <td>{{ $theme->status }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No themes found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
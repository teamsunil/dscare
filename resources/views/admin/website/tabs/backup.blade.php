<div class="tab-backup-content">
    <h4>Backups</h4>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($backups as $backup)
                <tr>
                    <td>{{ $backup->created_at }}</td>
                    <td>{{ $backup->type }}</td>
                    <td>{{ $backup->status }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No backups found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
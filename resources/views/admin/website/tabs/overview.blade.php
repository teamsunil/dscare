<div class="tab-overview-content">
    <h4>Website Overview</h4>
    <ul>
        <li><strong>Name:</strong> {{ $website->name }}</li>
        <li><strong>URL:</strong> {{ $website->url }}</li>
        <li><strong>Status:</strong> {{ $website->status ?? 'N/A' }}</li>
        <li><strong>Created:</strong> {{ $website->created_at }}</li>
        <li><strong>Last Updated:</strong> {{ $website->updated_at }}</li>
    </ul>
</div>
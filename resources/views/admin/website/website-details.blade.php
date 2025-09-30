@php
	// Get the website URL for JS fetch
	$wpUrl = $website->url ?? '';
@endphp

@extends('admin.layouts.app')

@section('content')



<!-- Back Button and Page Title -->
<div style="margin: 32px 0 18px 0; display: flex; align-items: flex-end; flex-wrap: wrap; gap: 0 32px;">
	
	
    <a href="javascript:history.go(-2)" style="
		display: inline-flex;
		align-items: center;
		gap: 10px;
        margin-left: 7%;
		padding: 10px 26px;
		border-radius: 8px;
		font-weight: 600;
		font-size: 1.08rem;
		text-decoration: none;
		background: linear-gradient(90deg, #f48226 0%, #ffb86c 100%);
		color: #fff;
		border: none;
		box-shadow: 0 2px 8px rgba(44,67,124,0.07);
		transition: background 0.2s, box-shadow 0.2s;
		margin-bottom: 6px;
	"
	onmouseover="this.style.background='linear-gradient(90deg,#ffb86c 0%,#f48226 100%)'"
	onmouseout="this.style.background='linear-gradient(90deg,#f48226 0%,#ffb86c 100%)'"
	>
		<i class="fas fa-arrow-left" style="font-size:1.1em;"></i> Back to Websites List
	</a>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
	/* --- Copied and adapted from view-website.blade.php --- */
	.dashboard_table {
		width: 100%;
		max-width: 1200px;
		margin: 0 auto;
		border-radius: 16px;
		background: #fff;
		box-shadow: 0 4px 24px rgba(44,67,124,0.08);
		padding: 0;
	}
	.dashboard_table .tablist_btns {
		background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.90) 50%, rgba(248,250,252,0.95) 100%);
		width: 100%;
		padding: 0 20px;
	}
	.dashboard_table .tablist {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		gap: 8px;
		padding: 26px 0;
		align-items: center;
		margin: auto;
	}
	.dashboard_table .tab {
		background: #2c437c;
		color: #fff;
		border: none;
		border-radius: 8px 8px 0 0;
		padding: 12px 24px;
		font-size: 1.1rem;
		font-weight: 600;
		cursor: pointer;
		transition: background 0.2s;
		display: flex;
		align-items: center;
		gap: 8px;
	}
	.dashboard_table .tab.active {
		background: #f48226;
		color: #fff;
	}
	.dashboard_table .panels {
		background: #fff;
		border-radius: 0 0 16px 16px;
		padding: 32px 24px;
	}
	.panel { display: none; }
	.panel.active { display: block; }
	.management-card {
		background: #f8fafc;
		border-radius: 12px;
		padding: 1.5rem;
		margin-bottom: 1.5rem;
		box-shadow: 0 2px 8px rgba(44,67,124,0.04);
	}
	.card-title { font-size: 1.2rem; font-weight: 700; color: #2c437c; margin-bottom: 0.5rem; }
	.stat-item { margin-bottom: 0.5rem; }
	.stat-value { font-size: 1.3rem; font-weight: 600; color: #f48226; }
	.stat-label { font-size: 0.95rem; color: #2c437c; }
	.badge.bg-success { background: #28a745 !important; color: #fff; }
	.badge.bg-warning { background: #ffc107 !important; color: #000; font-weight: 600; }
	.badge.bg-info { background: #17a2b8 !important; color: #fff; }
	.badge.bg-secondary { background: #6c757d !important; color: #fff; }
	.badge { padding: 0.4em 0.7em; border-radius: 6px; font-size: 0.95em; }
	@media (max-width: 991px) {
		.dashboard_table .tablist { width: 800px; overflow-x: scroll; }
		.dashboard_table .panels { padding: 16px 4px; }
	}
	@media (max-width: 768px) {
		.dashboard_table .tablist { grid-template-columns: 1fr; }
		.dashboard_table .panels { padding: 8px 2px; }
	}
</style>

<div class="dashboard_table mt-4 mb-4">
	<div style="display:flex; justify-content:flex-end; margin: 0 24px 12px 0;">
		<button id="btn-reload-data" class="btn btn-sm btn-primary">Reload Data</button>
	</div>
	<div class="tablist_btns">
		<div class="tablist" role="tablist">
			<button class="tab active" data-id="tab-sitehealth" type="button"><i class="fas fa-heartbeat"></i> Site Health</button>
			<button class="tab" data-id="tab-security" type="button"><i class="fas fa-shield-alt"></i> Security</button>
			<button class="tab" data-id="tab-ssl" type="button"><i class="fas fa-lock"></i> SSL</button>
			   <button class="tab" data-id="tab-dbopt" type="button"><i class="fas fa-database"></i> DB Optimization</button>
		</div>
	</div>
	<div class="panels">
		<!-- Site Health Tab -->
		   <div class="panel active" id="tab-sitehealth-panel">
			   <div class="management-card">
				   <div class="card-title">Site Health Overview</div>
				   @php
					   $sh = data_get($data, 'site_health', []);
					   $score = $sh['score'] ?? null;
					   $critical = $sh['status_summary']['critical'] ?? 0;
					   $recommended = $sh['status_summary']['recommended'] ?? 0;
					   $good = $sh['status_summary']['good'] ?? 0;
					   $total = ($critical + $recommended + $good) ?: 1;
					   $percent = $score ?? round(($good / $total) * 100);
					   $async = $sh['async_tests'] ?? [];
				   @endphp
				   <div style="margin-bottom:1.2rem;">
					   <div style="font-size:1.1rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;">Overall Score: <span class="badge bg-info" style="font-size:1.1rem;">{{ $score ?? 'N/A' }}%</span></div>
					   <div style="background:#e9ecef; border-radius:8px; height:18px; width:100%; overflow:hidden; margin-bottom:0.5rem;">
						   <div style="background:linear-gradient(90deg,#44a08d,#4ecdc4); height:100%; width:{{ $percent }}%; border-radius:8px;"></div>
					   </div>
					   <div style="display:flex; gap:1.5rem; font-size:1rem;">
						   <span><span class="badge bg-danger">Critical</span> {{ $critical }}</span>
						   <span><span class="badge bg-warning">Recommended</span> {{ $recommended }}</span>
						   <span><span class="badge bg-success">Good</span> {{ $good }}</span>
					   </div>
				   </div>
				   <div style="margin-bottom:1.2rem;">
					   <div style="font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;">Tests</div>
					   <ul style="list-style:none; padding:0; margin:0;">
						   @foreach($async as $test)
							   @php
								   $status = $test['status'] ?? 'unknown';
								   $badge = $test['badge']['label'] ?? '';
								   $badgeColor = $test['badge']['color'] ?? 'blue';
								   $label = $test['label'] ?? '';
								   $desc = $test['description'] ?? '';
								   $statusMap = [
									   'good' => ['bg-success','Good'],
									   'recommended' => ['bg-warning','Recommended'],
									   'critical' => ['bg-danger','Critical'],
									   'unknown' => ['bg-secondary','Unknown']
								   ];
								   [$statusClass, $statusText] = $statusMap[$status] ?? ['bg-secondary','Unknown'];
							   @endphp
							   <li style="margin-bottom:1.1rem; background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(44,67,124,0.06); padding:1rem 1.2rem;">
								   <div style="display:flex; align-items:center; gap:0.7rem; margin-bottom:0.3rem;">
									   <span class="badge {{ $statusClass }}" style="min-width:80px; text-align:center;">{{ $statusText }}</span>
									   <span class="badge bg-info" style="background:{{ $badgeColor }}; color:#fff; min-width:80px;">{{ $badge }}</span>
									   <span style="font-weight:600; color:#2c437c;">{!! $label !!}</span>
								   </div>
								   <div style="color:#444; font-size:0.98rem;">{!! $desc !!}</div>
							   </li>
						   @endforeach
					   </ul>
				   </div>
				   @if (data_get($sh, 'last_updated'))
					   <div style="font-size:0.95rem; color:#888;">Last checked: {{ data_get($sh, 'last_updated') }}</div>
				   @endif
			   </div>
		   </div>
		<!-- Security Tab -->
		   <div class="panel" id="tab-security-panel">
			   <div class="management-card">
				   <div class="card-title">Security Status</div>
				   <div id="security-loading" class="stat-item">Loading security report...</div>
				   <div id="security-content" style="display:none;"></div>
				   <div id="security-error" class="text-danger" style="display:none;"></div>
			   </div>
		   </div>
		<!-- SSL Tab -->
		   <div class="panel" id="tab-ssl-panel">
			   <div class="management-card">
				   <div class="card-title">SSL Information</div>
				   <div id="ssl-loading" class="stat-item">Loading SSL details...</div>
				   <div id="ssl-content" style="display:none;"></div>
				   <div id="ssl-error" class="text-danger" style="display:none;"></div>
			   </div>
		   </div>
		   <!-- DB Optimization Tab -->
		   <div class="panel" id="tab-dbopt-panel">
			   <div class="management-card">
				   <div class="card-title">Database Optimization</div>
				   <div id="dbopt-loading" class="stat-item">Loading optimization data...</div>
				   <div id="dbopt-content" style="display:none;"></div>
				   <div id="dbopt-error" class="text-danger" style="display:none;"></div>
				   <div id="dbopt-action-result" style="margin-top:1rem;"></div>
			   </div>
		   </div>
	</div>
</div>

<script>
	// Tab switching logic
	document.addEventListener("DOMContentLoaded", function() {
		const tabs = document.querySelectorAll(".tablist .tab");
		const panels = document.querySelectorAll(".panel");
		tabs.forEach(tab => {
			tab.addEventListener("click", function() {
				tabs.forEach(t => t.classList.remove("active"));
				tab.classList.add("active");
				panels.forEach(p => p.classList.remove("active"));
				const id = tab.getAttribute("data-id");
				document.getElementById(id+"-panel").classList.add("active");

				// If Security tab, fetch security report if not already loaded
				if (id === 'tab-security') {
					loadSecurityReport();
				}
				// If SSL tab, fetch SSL details
				if (id === 'tab-ssl') {
					loadSSLDetails();
				}
				// If DB Optimization tab, fetch DB optimization data
				if (id === 'tab-dbopt') {
					loadDBOptData();
				}
			});
		});
		// Optionally, auto-load security report if security tab is default
		if (document.querySelector('.tab.active').getAttribute('data-id') === 'tab-security') {
			loadSecurityReport();
		}
		// Optionally, auto-load SSL details if SSL tab is default
		if (document.querySelector('.tab.active').getAttribute('data-id') === 'tab-ssl') {
			loadSSLDetails();
		}
		// Optionally, auto-load DB optimization if DB Optimization tab is default
		if (document.querySelector('.tab.active').getAttribute('data-id') === 'tab-dbopt') {
			loadDBOptData();
		}
// Fetch and render DB Optimization data from WordPress
function loadDBOptData() {
	const loading = document.getElementById('dbopt-loading');
	const content = document.getElementById('dbopt-content');
	const error = document.getElementById('dbopt-error');
	const resultDiv = document.getElementById('dbopt-action-result');
	loading.style.display = '';
	content.style.display = 'none';
	error.style.display = 'none';
	resultDiv.innerHTML = '';

	// Get WP URL from PHP
	const wpUrl = @json($wpUrl);
	if (!wpUrl) {
		loading.style.display = 'none';
		error.style.display = '';
		error.textContent = 'No WordPress URL found.';
		return;
	}

	// Reload website data button
	const reloadBtn = document.getElementById('btn-reload-data');
	if (reloadBtn) {
		reloadBtn.addEventListener('click', function () {
			reloadBtn.disabled = true;
			reloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Reloading...';
			const websiteId = @json($website->id ?? $id ?? null);
			if (!websiteId) {
				alert('Website ID not found.');
				reloadBtn.disabled = false;
				reloadBtn.innerHTML = 'Reload Data';
				return;
			}

			fetch('/admin/website/reload/' + encodeURIComponent(websiteId) + '/data', { method: 'GET' })
				.then(res => res.json().catch(() => ({})))
				.then(data => {
					// The controller returns redirects/back with flash messages; when called via fetch we expect JSON if successful.
					// If fetch returns an empty object (because server responded with redirect/html), treat as success and reload.
					// Reload the page to show updated data.
					location.reload();
				})
				.catch(err => {
					console.error('Reload data error', err);
					alert('Failed to reload data. Check console for details.');
					reloadBtn.disabled = false;
					reloadBtn.innerHTML = 'Reload Data';
				});
		});
	}
	fetch(wpUrl.replace(/\/$/, '') + '/wp-json/laravel-sso/v1/db-optimize-data')
		.then(res => res.json())
		.then(data => {
			loading.style.display = 'none';
			if (!data || !data.optimization_report) {
				error.style.display = '';
				error.textContent = 'No optimization data found.';
				return;
			}
			content.style.display = '';
			content.innerHTML = renderDBOptData(data.optimization_report);
			attachDBOptActionButtons(wpUrl, resultDiv);
		})
		.catch(e => {
			loading.style.display = 'none';
			error.style.display = '';
			error.textContent = 'Failed to fetch optimization data.';
		});
}

// Attach click events to DB optimization action buttons
function attachDBOptActionButtons(wpUrl, resultDiv) {
	const actions = [
		{ selector: '#btn-delete-revisions', action: 'delete_revisions', label: 'Delete Revisions', desc: 'Removes all post revisions from the database.' },
		{ selector: '#btn-delete-auto-drafts', action: 'delete_auto_drafts', label: 'Delete Auto Drafts', desc: 'Deletes all auto-draft posts.' },
		{ selector: '#btn-empty-trash-posts', action: 'empty_trash_posts', label: 'Empty Trash Posts', desc: 'Empties the trash for posts.' },
		{ selector: '#btn-delete-spam-comments', action: 'delete_spam_comments', label: 'Delete Spam Comments', desc: 'Deletes all comments marked as spam.' },
		{ selector: '#btn-delete-trash-comments', action: 'delete_trash_comments', label: 'Delete Trash Comments', desc: 'Deletes all trashed comments.' },
		{ selector: '#btn-delete-orphan-postmeta', action: 'delete_orphan_postmeta', label: 'Delete Orphan Postmeta', desc: 'Removes postmeta entries with no parent post.' },
		{ selector: '#btn-delete-orphan-usermeta', action: 'delete_orphan_usermeta', label: 'Delete Orphan Usermeta', desc: 'Removes usermeta entries with no parent user.' },
		{ selector: '#btn-delete-orphan-commentmeta', action: 'delete_orphan_commentmeta', label: 'Delete Orphan Commentmeta', desc: 'Removes commentmeta entries with no parent comment.' },
		{ selector: '#btn-delete-expired-transients', action: 'delete_expired_transients', label: 'Delete Expired Transients', desc: 'Deletes expired transients from wp_options.' },
		{ selector: '#btn-optimize-tables', action: 'optimize_tables', label: 'Optimize Tables', desc: 'Runs OPTIMIZE TABLE on all database tables.' },
	];
	actions.forEach(({ selector, action, label }) => {
		const btn = document.querySelector(selector);
		if (btn) {
			btn.onclick = function() {
				btn.disabled = true;
				btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + label;
				fetch(wpUrl.replace(/\/$/, '') + '/wp-json/laravel-sso/v1/db-optimize-action?action=' + encodeURIComponent(action), {
					method: 'GET'
				})
				.then(res => res.json())
				.then(data => {
					btn.disabled = false;
					btn.innerHTML = btn.getAttribute('data-original-label');
					if (data && data.status === 'success') {
						resultDiv.innerHTML = `<div class='alert alert-success mt-2'>${label} completed! <pre style='margin:0;'>${JSON.stringify(data.results, null, 2)}</pre></div>`;
						loadDBOptData();
					} else {
						resultDiv.innerHTML = `<div class='alert alert-danger mt-2'>${label} failed.</div>`;
					}
				})
				.catch(() => {
					btn.disabled = false;
					btn.innerHTML = btn.getAttribute('data-original-label');
					resultDiv.innerHTML = `<div class='alert alert-danger mt-2'>${label} failed.</div>`;
				});
			};
			if (!btn.getAttribute('data-original-label')) {
				btn.setAttribute('data-original-label', btn.innerHTML);
			}
		}
	});
}

// Render the DB Optimization data HTML
function renderDBOptData(opt) {
	let html = '';
	// Posts
	html += `<div style='margin-bottom:1.2rem;'><div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Posts</div>`;
	html += `<div style='display:flex; flex-direction:column; gap:0.7rem;'>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-info'>Revisions: ${opt.posts.revisions}</span>
		<button id='btn-delete-revisions' class='btn btn-sm btn-primary'>Delete Revisions</button>
		<span style='color:#888; font-size:0.97em;'>Removes all post revisions from the database.</span>
	</div>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-warning'>Auto Drafts: ${opt.posts.auto_drafts}</span>
		<button id='btn-delete-auto-drafts' class='btn btn-sm btn-primary'>Delete Auto Drafts</button>
		<span style='color:#888; font-size:0.97em;'>Deletes all auto-draft posts.</span>
	</div>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-danger'>Trashed: ${opt.posts.trashed}</span>
		<button id='btn-empty-trash-posts' class='btn btn-sm btn-primary'>Empty Trash</button>
		<span style='color:#888; font-size:0.97em;'>Empties the trash for posts.</span>
	</div>`;
	html += `</div></div>`;
	// Comments
	html += `<div style='margin-bottom:1.2rem;'><div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Comments</div>`;
	html += `<div style='display:flex; flex-direction:column; gap:0.7rem;'>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-warning'>Spam: ${opt.comments.spam}</span>
		<button id='btn-delete-spam-comments' class='btn btn-sm btn-primary'>Delete Spam</button>
		<span style='color:#888; font-size:0.97em;'>Deletes all comments marked as spam.</span>
	</div>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-danger'>Trash: ${opt.comments.trash}</span>
		<button id='btn-delete-trash-comments' class='btn btn-sm btn-primary'>Delete Trash</button>
		<span style='color:#888; font-size:0.97em;'>Deletes all trashed comments.</span>
	</div>`;
	html += `</div></div>`;
	// Orphans
	html += `<div style='margin-bottom:1.2rem;'><div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Orphans</div>`;
	html += `<div style='display:flex; flex-direction:column; gap:0.7rem;'>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-info'>Postmeta: ${opt.orphans.postmeta}</span>
		<button id='btn-delete-orphan-postmeta' class='btn btn-sm btn-primary'>Delete Orphan Postmeta</button>
		<span style='color:#888; font-size:0.97em;'>Removes postmeta entries with no parent post.</span>
	</div>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-info'>Usermeta: ${opt.orphans.usermeta}</span>
		<button id='btn-delete-orphan-usermeta' class='btn btn-sm btn-primary'>Delete Orphan Usermeta</button>
		<span style='color:#888; font-size:0.97em;'>Removes usermeta entries with no parent user.</span>
	</div>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-info'>Commentmeta: ${opt.orphans.commentmeta}</span>
		<button id='btn-delete-orphan-commentmeta' class='btn btn-sm btn-primary'>Delete Orphan Commentmeta</button>
		<span style='color:#888; font-size:0.97em;'>Removes commentmeta entries with no parent comment.</span>
	</div>`;
	html += `</div></div>`;
	// Autoload Options
	html += `<div style='margin-bottom:1.2rem;'><div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Autoload Options</div>`;
	html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem;'>
		<span class='badge bg-info'>Count: ${opt.autoload_options.count}</span>
		<span class='badge bg-info'>Total Size KB: ${opt.autoload_options.total_size_kb}</span>
		<button id='btn-delete-expired-transients' class='btn btn-sm btn-primary'>Delete Expired Transients</button>
		<span style='color:#888; font-size:0.97em;'>Deletes expired transients from wp_options.</span>
	</div></div>`;
	// Fragmented Tables
	if (opt.fragmented_tables && opt.fragmented_tables.length) {
		html += `<div style='margin-bottom:1.2rem;'><div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Fragmented Tables</div>`;
		html += `<div style='overflow-x:auto;'><table class='table table-bordered' style='min-width:600px;'>
			<thead><tr>`;
		for (const key of Object.keys(opt.fragmented_tables[0])) {
			html += `<th>${key}</th>`;
		}
		html += `</tr></thead><tbody>`;
		for (const row of opt.fragmented_tables) {
			html += `<tr>`;
			for (const key of Object.keys(row)) {
				html += `<td>${row[key]}</td>`;
			}
			html += `</tr>`;
		}
		html += `</tbody></table></div>`;
		html += `<div style='display:flex; align-items:center; gap:1rem; background:#f8fafc; border-radius:8px; padding:0.7rem 1rem; margin-top:0.7rem;'>
			<button id='btn-optimize-tables' class='btn btn-sm btn-success'>Optimize Tables</button>
			<span style='color:#888; font-size:0.97em;'>Runs OPTIMIZE TABLE on all database tables.</span>
		</div></div>`;
	}
	return html;
}
	});
// Fetch and render SSL details from WordPress
function loadSSLDetails() {
	const loading = document.getElementById('ssl-loading');
	const content = document.getElementById('ssl-content');
	const error = document.getElementById('ssl-error');
	loading.style.display = '';
	content.style.display = 'none';
	error.style.display = 'none';

	// Get WP URL from PHP
	const wpUrl = @json($wpUrl);
	if (!wpUrl) {
		loading.style.display = 'none';
		error.style.display = '';
		error.textContent = 'No WordPress URL found.';
		return;
	}
	fetch(wpUrl.replace(/\/$/, '') + '/wp-json/laravel-sso/v1/site-ssl-details')
		.then(res => res.json())
		.then(data => {
			loading.style.display = 'none';
			if (!data || !data.status) {
				error.style.display = '';
				error.textContent = 'No SSL details found.';
				return;
			}
			content.style.display = '';
			content.innerHTML = renderSSLDetails(data);
		})
		.catch(e => {
			loading.style.display = 'none';
			error.style.display = '';
			error.textContent = 'Failed to fetch SSL details.';
		});
}

// Render the SSL details HTML
function renderSSLDetails(ssl) {
	let statusMap = {
		'valid': ['bg-success', 'Valid'],
		'expired': ['bg-danger', 'Expired'],
		'self-signed': ['bg-warning', 'Self-signed'],
		'invalid': ['bg-danger', 'Invalid'],
		'unknown': ['bg-secondary', 'Unknown']
	};
	let [statusClass, statusText] = statusMap[ssl.status] || ['bg-secondary', ssl.status];
	let html = `<div style='margin-bottom:1.2rem;'>
		<div style='font-size:1.1rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Domain: <span style='color:#222;'>${ssl.domain}</span></div>
		<div style='display:flex; gap:1.2rem; flex-wrap:wrap; margin-bottom:0.7rem;'>
			<span class='badge ${statusClass}' style='font-size:1.1em;'>${statusText}</span>
			<span class='badge bg-info'>Issuer: ${ssl.issuer}</span>
		</div>
		<div style='margin-bottom:0.5rem;'><strong>Valid From:</strong> <span>${ssl.valid_from}</span></div>
		<div style='margin-bottom:0.5rem;'><strong>Valid To:</strong> <span>${ssl.valid_to}</span></div>
		<div style='margin-bottom:0.5rem;'><strong>Days Left:</strong> <span>${ssl.days_left}</span></div>
		<div style='margin-bottom:0.5rem; color:#e55353;'><strong>Message:</strong> <span>${ssl.message}</span></div>
	</div>`;
	return html;
}

	// Fetch and render security report and headers from WordPress
		function loadSecurityReport() {
			const loading = document.getElementById('security-loading');
			const content = document.getElementById('security-content');
			const error = document.getElementById('security-error');
			loading.style.display = '';
			content.style.display = 'none';
			error.style.display = 'none';

			// Get WP URL from PHP
			const wpUrl = @json($wpUrl);
			if (!wpUrl) {
				loading.style.display = 'none';
				error.style.display = '';
				error.textContent = 'No WordPress URL found.';
				return;
			}
			// Fetch security report, then fetch headers from the site root (client-side)
			fetch(wpUrl.replace(/\/$/, '') + '/wp-json/laravel-sso/v1/wp-security-report')
				.then(res => res.json())
				.then(reportData => {
					loading.style.display = 'none';
					if (!reportData || !reportData.security_report) {
						error.style.display = '';
						error.textContent = 'No security report data found.';
						return;
					}
					content.style.display = '';
					content.innerHTML = renderSecurityReport(reportData.security_report);
					// Now fetch headers from the site root
					fetchSecurityHeadersFromSite(wpUrl, content);
				})
				.catch(e => {
					loading.style.display = 'none';
					error.style.display = '';
					error.textContent = 'Failed to fetch security report.';
				});
	// Fetch security headers directly from the website root
	function fetchSecurityHeadersFromSite(wpUrl, contentDiv) {
		// Use a HEAD request to get headers (may be blocked by CORS)
		fetch(wpUrl, { method: 'HEAD' })
			.then(res => {
				// List of headers to check
				const headerKeys = [
					'strict-transport-security',
					'content-security-policy',
					'x-frame-options',
					'x-content-type-options',
					'referrer-policy',
					'permissions-policy',
					'x-xss-protection',
					'expect-ct',
					'access-control-allow-origin'
				];
				let headers = {};
				headerKeys.forEach(key => {
					const val = res.headers.get(key);
					if (val !== null) headers[key] = val;
				});
				contentDiv.innerHTML += renderSecurityHeaders(headers);
			})
			.catch(() => {
				contentDiv.innerHTML += `<div class='alert alert-warning mt-2'>Unable to fetch security headers (may be blocked by CORS).</div>`;
			});
	}
		}

	// Render the security report HTML
	function renderSecurityReport(report) {
		let html = '';
		// ...existing code...
		html += `<div style='margin-bottom:1.2rem;'>
			<div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Environment</div>
			<div style='display:flex; gap:1.2rem; flex-wrap:wrap;'>
				<span class='badge bg-info'>WP: ${report.env.wp_version}</span>
				<span class='badge bg-info'>PHP: ${report.env.php_version}</span>
				<span class='badge bg-info'>MySQL: ${report.env.mysql_version}</span>
				<span class='badge ${report.env.is_ssl ? 'bg-success' : 'bg-warning'}'>SSL: ${report.env.is_ssl ? 'Enabled' : 'Disabled'}</span>
			</div>
		</div>`;
		// ...existing code...
		html += `<div style='margin-bottom:1.2rem;'>
			<div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>WP Constants</div>
			<ul style='columns:2; margin:0; padding-left:1.2em;'>`;
			for (const [k, v] of Object.entries(report.constants)) {
				html += `<li style='margin-bottom:0.3em;'>${k}: <span class='badge ${v ? 'bg-success' : 'bg-warning'}'>${v ? 'True' : 'False'}</span></li>`;
			}
		html += `</ul></div>`;
		// ...existing code...
		html += `<div style='margin-bottom:1.2rem;'>
			<div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Salts</div>
			<ul style='columns:2; margin:0; padding-left:1.2em;'>`;
			for (const [k, v] of Object.entries(report.salts)) {
				html += `<li style='margin-bottom:0.3em;'>${k}: <span class='badge ${v.defined && v.strong ? 'bg-success' : 'bg-warning'}'>${v.defined ? (v.strong ? 'Strong' : 'Weak') : 'Not Defined'}</span></li>`;
			}
		html += `</ul></div>`;
		// ...existing code...
		html += `<div style='margin-bottom:1.2rem;'>
			<div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Filesystem</div>
			<ul style='columns:2; margin:0; padding-left:1.2em;'>`;
			for (const [k, v] of Object.entries(report.filesystem)) {
				html += `<li style='margin-bottom:0.3em;'>${k}: <span class='badge ${v ? 'bg-success' : 'bg-warning'}'>${v ? 'OK' : 'Check'}</span></li>`;
			}
		html += `</ul></div>`;
		// ...existing code...
		html += `<div style='margin-bottom:1.2rem;'>
			<div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>XML-RPC</div>
			<span class='badge ${report.xmlrpc.enabled ? 'bg-success' : 'bg-warning'}'>${report.xmlrpc.enabled ? 'Enabled' : 'Disabled'}</span>
		</div>`;
		// ...existing code...
		html += `<div style='margin-bottom:1.2rem;'>
			<div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Users</div>
			<span class='badge bg-info'>Admins: ${report.users.admin_count}</span>`;
		if (report.users.weak_usernames_found && report.users.weak_usernames_found.length) {
			html += ` | Weak usernames: <span class='badge bg-warning'>${report.users.weak_usernames_found.join(', ')}</span>`;
		}
		html += `</div>`;
		// ...existing code...
		html += `<div style='margin-bottom:1.2rem;'>
			<div style='font-size:1.05rem; font-weight:600; color:#2c437c; margin-bottom:0.5rem;'>Plugins</div>
			<span class='badge bg-info'>Active: ${report.plugins.active.length}</span> &nbsp; <span class='badge bg-warning'>Updates: ${report.plugins.plugin_updates_count}</span>
		</div>`;
		// ...existing code...
		if (report.recommendations && report.recommendations.length) {
			html += `<div style='margin-bottom:1.2rem; background:#f8fafc; border-radius:8px; padding:1.1rem 1.2rem;'>
				<div style='font-size:1.08rem; font-weight:700; color:#2c437c; margin-bottom:0.7rem;'>Recommendations</div>`;
			for (const rec of report.recommendations) {
				html += `<div style='display:flex; align-items:flex-start; gap:0.7em; margin-bottom:0.4em;'>
					<span style='color:#e55353; font-size:1.1em; margin-top:2px;'>&#9888;</span>
					<span style='color:#222; font-size:1em;'>${rec}</span>
				</div>`;
			}
			html += `</div>`;
		}
		return html;
	}

	// Render security headers HTML
	function renderSecurityHeaders(headers) {
		// Descriptions for common headers
		const headerDescriptions = {
			'strict-transport-security': 'Enforces secure (HTTPS) connections to the server.',
			'content-security-policy': 'Helps prevent XSS attacks by specifying allowed sources of content.',
			'x-frame-options': 'Protects against clickjacking by controlling whether the site can be framed.',
			'x-content-type-options': 'Prevents MIME-sniffing attacks.',
			'referrer-policy': 'Controls how much referrer information is sent with requests.',
			'permissions-policy': 'Controls which browser features can be used in the site.',
			'x-xss-protection': 'Enables cross-site scripting filters in browsers.',
			'expect-ct': 'Enables Certificate Transparency reporting.',
			'access-control-allow-origin': 'Specifies which origins can access resources.'
		};
		if (!headers || Object.keys(headers).length === 0) {
			return `<div class='alert alert-warning mt-2'>No security headers found or accessible.</div>`;
		}
		let html = `<div style='margin-top:2rem; margin-bottom:1.2rem; background:#f8fafc; border-radius:12px; padding:1.2rem;'>`;
		html += `<div style='font-size:1.15rem; font-weight:700; color:#2c437c; margin-bottom:0.7rem;'><i class="fas fa-shield-alt"></i> Security Headers</div>`;
		html += `<table class='table table-bordered' style='background:#fff;'>`;
		html += `<thead><tr><th>Header</th><th>Value</th><th>Description</th></tr></thead><tbody>`;
		for (const [header, value] of Object.entries(headers)) {
			html += `<tr>`;
			html += `<td style='font-weight:600;'>${header}</td>`;
			html += `<td style='font-family:monospace;'>${value}</td>`;
			html += `<td style='color:#555;'>${headerDescriptions[header] || ''}</td>`;
			html += `</tr>`;
		}
		html += `</tbody></table></div>`;
		return html;
	}
</script>

@stop

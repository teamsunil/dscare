import fetch from 'node-fetch';

// Configuration
const API_BASE_URL = 'http://127.0.0.1:8000/api'; // Change to your Laravel app URL
const CHECK_INTERVAL = 1800000; // Check every 30 minutes

async function checkWebsiteStatus() {
    try {
        console.log('Fetching website status from API...');
        
        const requestOptions = {
            method: "GET",
            redirect: "follow"
        };
        
        const response = await fetch(`${API_BASE_URL}/website-list`, requestOptions);
        const data = await response.json();
        
        if (data.success) {
            console.log(`Found ${data.total} websites to check`);
            
            for (const website of data.data) {
                await checkSingleWebsite(website);
            }
        } else {
            console.error('Failed to fetch website data from API');
        }
    } catch (error) {
        console.error('Error fetching website status:', error.message);
    }
}

async function checkSingleWebsite(website) {
    try {
        console.log(`Checking ${website.url}...`);
        
        const startTime = Date.now();
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 50000);
        
        const response = await fetch(website.url, {
            method: 'GET',
            signal: controller.signal,
            headers: {
                'User-Agent': 'DS-Care-Status-Checker/1.0'
            },
            redirect: 'follow'
        });
        
        clearTimeout(timeoutId);
        
        const responseTime = Date.now() - startTime;
        const status = response.ok ? 'up' : 'down';
        
        console.log(`${website.url} - Status: ${status} (${response.status}) - Response time: ${responseTime}ms`);
        
        // Update status in Laravel API
        await updateWebsiteStatus(website.id, status, responseTime);
        
    } catch (error) {
        if (error.name === 'AbortError') {
            console.log(`${website.url} - Status: down - Error: Request timeout`);
        } else {
            console.log(`${website.url} - Status: down - Error: ${error.message}`);
        }
        await updateWebsiteStatus(website.id, 'down', null);
    }
}

// Optional: Function to update status back to Laravel
async function updateWebsiteStatus(websiteId, status, responseTime) {
    try {
        await fetch(`${API_BASE_URL}/website-status/${websiteId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                status: status,
                response_time: responseTime,
                checked_at: new Date().toISOString()
            })
        });
    } catch (error) {
        console.error(`Failed to update status for website ${websiteId}:`, error.message);
    }
}

// Start the status checker
console.log('Website Status Checker started...');
console.log(`Checking websites every ${CHECK_INTERVAL / 60000} minutes`);

// Run immediately
checkWebsiteStatus();

// Then run at intervals
setInterval(checkWebsiteStatus, CHECK_INTERVAL);
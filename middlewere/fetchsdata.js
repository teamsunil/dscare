import fetch from 'node-fetch';

// Configuration
const API_BASE_URL = `${process.env.APP_URL}/api`;
const CHECK_INTERVAL = 1800000; // Check every 30 minutes

async function fetchAndUpdateWebsiteData() {
    try {
        console.log('Fetching website data with authentication...');
        
        const requestOptions = {
            method: "GET",
            redirect: "follow"
        };
        
        const response = await fetch(`${API_BASE_URL}/update-status-data`, requestOptions);
        const data = await response.json();
        
        if (data.success) {
            console.log(`Found ${data.total} websites to fetch data from`);
            console.log('Website data:', JSON.stringify(data.data, null, 2));
            
            for (const website of data.data) {
                await fetchSingleWebsiteData(website);
            }
        } else {
            console.error('Failed to fetch website data from API');
        }
    } catch (error) {
        console.error('Error fetching website data:', error.message);
    }
}

async function fetchSingleWebsiteData(website) {
    try {
        console.log(`Fetching data from ${website.url}...`);
        
        const requestOptions = {
            method: "GET",
            redirect: "follow",
            headers: {
                'iss': website.iss,
                'secret': website.sig
            }
        };
        
        const response = await fetch(website.status_endpoint, requestOptions);
        
        if (response.ok) {
            const wpData = await response.json();
            console.log(`${website.url} - Data fetched successfully`);
            console.log('WordPress data:', JSON.stringify(wpData, null, 2));
            
            // Send data back to Laravel for storage
            await updateWebsiteData(website.id, wpData.data);
        } else {
            console.log(`${website.url} - Failed to fetch data: ${response.status}`);
        }
        
    } catch (error) {
        console.log(`${website.url} - Error: ${error.message}`);
    }
}

async function updateWebsiteData(websiteId, wpData) {
    try {
        const response = await fetch(`${API_BASE_URL}/website-data/${websiteId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                data: wpData
            })
        });

        
        if (response.ok) {
            console.log(`Website ${websiteId} data updated successfully`);
        }
    } catch (error) {
        console.error(`Failed to update data for website ${websiteId}:`, error.message);
    }
}

// Start the data fetcher
console.log('Website Data Fetcher started...');
console.log(`Fetching website data every ${CHECK_INTERVAL / 60000} minutes`);

// Log with timestamp
function logWithTimestamp(message) {
    console.log(`[${new Date().toISOString()}] ${message}`);
}

// Run immediately
fetchAndUpdateWebsiteData();

// Then run at intervals
setInterval(fetchAndUpdateWebsiteData, CHECK_INTERVAL);
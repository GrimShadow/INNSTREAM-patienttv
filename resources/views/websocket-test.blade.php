<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Test - Display Connection</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white min-h-screen p-8">
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold text-center">WebSocket Test - Display Connection</h1>
        
        <!-- Connection Status -->
        <div class="bg-gray-800 p-6 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Connection Status</h2>
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-gray-500 rounded-full" id="status-indicator"></span>
                    <span id="status-text">Connecting...</span>
                </div>
                <div class="text-sm text-gray-400" id="connection-address"></div>
            </div>
        </div>

        <!-- Display Connection Test -->
        <div class="bg-gray-800 p-6 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Display Connection Test</h2>
            <div class="space-y-4">
                <button id="test-display-connect" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                    Test Display Connection
                </button>
                <button id="test-device-info-connect" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg">
                    Test Device Info Connection
                </button>
                <div id="display-result" class="text-sm"></div>
            </div>
        </div>

        <!-- Channel Test -->
        <div class="bg-gray-800 p-6 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Channel Test</h2>
            <div class="space-y-4">
                <button id="join-channel" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg">
                    Join Test Channel
                </button>
                <button id="test-broadcast" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg">
                    Test Broadcast
                </button>
            </div>
        </div>

        <!-- Console Log -->
        <div class="bg-gray-800 p-6 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Console Log</h2>
            <div id="console-log" class="bg-gray-900 p-4 rounded-lg h-64 overflow-y-auto text-sm font-mono">
                <div class="text-gray-500">Console output will appear here...</div>
            </div>
        </div>
    </div>

    <script>
        // Console logging function
        function log(message) {
            const console = document.getElementById('console-log');
            const timestamp = new Date().toLocaleTimeString();
            const logEntry = document.createElement('div');
            logEntry.className = 'mb-2';
            logEntry.innerHTML = `<span class="text-gray-400">[${timestamp}]</span> ${message}`;
            console.appendChild(logEntry);
            console.scrollTop = console.scrollHeight;
        }

        // Wait for Echo to be available
        document.addEventListener('DOMContentLoaded', function() {
            log('Page loaded, waiting for Echo...');
            
            // Check if Echo is available
            if (typeof window.Echo !== 'undefined') {
                log('Echo is available');
                initializeWebSocket();
            } else {
                log('Echo not available, waiting...');
                // Wait for Echo to be loaded
                const checkEcho = setInterval(() => {
                    if (typeof window.Echo !== 'undefined') {
                        clearInterval(checkEcho);
                        log('Echo is now available');
                        initializeWebSocket();
                    }
                }, 100);
            }
        });

        function initializeWebSocket() {
            log('Testing WebSocket connection...');
            
            try {
                // Test if Echo connector is available
                if (window.Echo.connector) {
                    log('Echo connector available');
                    
                    // Subscribe to displays channel
                    const channel = window.Echo.channel('displays');
                    
                    channel.subscribed(() => {
                        log('Successfully subscribed to displays channel');
                    });
                    
                    channel.listen('.display.code', (e) => {
                        log(`Received display code event: ${JSON.stringify(e)}`);
                    });
                    
                    channel.listen('.display.disconnected', (e) => {
                        log(`Display disconnected: ${JSON.stringify(e)}`);
                    });
                    
                    // Update status
                    updateStatus('Connected to displays channel');
                    
                } else {
                    log('Echo connector not available');
                    updateStatus('Echo connector not available');
                }
                
            } catch (error) {
                log(`Error initializing WebSocket: ${error.message}`);
                updateStatus('WebSocket initialization failed');
            }
        }

        function updateStatus(message) {
            const statusText = document.getElementById('status-text');
            const statusIndicator = document.getElementById('status-indicator');
            
            if (statusText) statusText.textContent = message;
            
            if (message.includes('Connected')) {
                statusIndicator.className = 'w-3 h-3 bg-green-500 rounded-full';
            } else if (message.includes('Error') || message.includes('failed')) {
                statusIndicator.className = 'w-3 h-3 bg-red-500 rounded-full';
            } else {
                statusIndicator.className = 'w-3 h-3 bg-yellow-500 rounded-full';
            }
        }

        // Test display connection
        document.getElementById('test-display-connect').addEventListener('click', async function() {
            const resultDiv = document.getElementById('display-result');
            resultDiv.innerHTML = 'Testing basic connection...';
            
            try {
                const response = await fetch('/api/websocket/display/connect', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({})
                });
                
                const data = await response.json();
                
                if (data.success) {
                    resultDiv.innerHTML = `
                        <div class="text-green-400">
                            ✅ Basic display connected successfully!<br>
                            Connection Code: <strong>${data.data.connection_code}</strong><br>
                            Display ID: ${data.data.display_id}
                        </div>
                    `;
                    log(`Basic display connected with code: ${data.data.connection_code}`);
                } else {
                    resultDiv.innerHTML = `<div class="text-red-400">❌ ${data.message}</div>`;
                    log(`Basic display connection failed: ${data.message}`);
                }
                
            } catch (error) {
                resultDiv.innerHTML = `<div class="text-red-400">❌ Error: ${error.message}</div>`;
                log(`Basic display connection error: ${error.message}`);
            }
        });

        // Test device info connection
        document.getElementById('test-device-info-connect').addEventListener('click', async function() {
            const resultDiv = document.getElementById('display-result');
            resultDiv.innerHTML = 'Testing device info connection...';
            
            try {
                const deviceInfo = {
                    name: "AndroidEEFF",
                    ip_address: "192.168.68.100",
                    mac_address: "AA:BB:CC:DD:EE:FF",
                    app_version: "1.0",
                    os: "Android TV",
                    version: "13.0",
                    firmware_version: "13.0"
                };
                
                const response = await fetch('/api/websocket/display/connect', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        device_info: deviceInfo
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    resultDiv.innerHTML = `
                        <div class="text-green-400">
                            ✅ Device info connection successful!<br>
                            Connection Code: <strong>${data.data.connection_code}</strong><br>
                            Display ID: ${data.data.display_id}<br>
                            Device Name: ${deviceInfo.name}<br>
                            OS: ${deviceInfo.os} ${deviceInfo.version}
                        </div>
                    `;
                    log(`Device info connection successful with code: ${data.data.connection_code}`);
                } else {
                    resultDiv.innerHTML = `<div class="text-red-400">❌ ${data.message}</div>`;
                    log(`Device info connection failed: ${data.message}`);
                }
                
            } catch (error) {
                resultDiv.innerHTML = `<div class="text-red-400">❌ Error: ${error.message}</div>`;
                log(`Device info connection error: ${error.message}`);
            }
        });

        // Join test channel
        document.getElementById('join-channel').addEventListener('click', function() {
            log('Manual channel test triggered');
            initializeWebSocket();
        });

        // Test broadcast
        document.getElementById('test-broadcast').addEventListener('click', async function() {
            try {
                const response = await fetch('/test-broadcast');
                const result = await response.text();
                log(`Broadcast test result: ${result}`);
            } catch (error) {
                log(`Broadcast test error: ${error.message}`);
            }
        });
    </script>
</body>
</html>

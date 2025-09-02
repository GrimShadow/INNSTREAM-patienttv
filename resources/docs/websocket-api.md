# WebSocket API Documentation

The INNSTREAM system uses WebSocket connections for real-time communication between displays and the server, along with HTTP API endpoints for display management.

## Overview

The WebSocket API provides real-time bidirectional communication between Android TV displays and the server. This enables instant updates, status monitoring, and remote control capabilities.

## Connection Details

### Server Configuration
- **Host**: `reverb.herd.test` (local development)
- **Port**: `443` (HTTPS)
- **Scheme**: `https`
- **App ID**: `1001`
- **App Key**: `laravel-herd`
- **App Secret**: `secret`

### Expose Tunnel (External Access)
- **URL**: `https://innstream-patienttv.sharedwithexpose.com`
- **Protocol**: HTTPS
- **WebSocket**: `wss://innstream-patienttv.sharedwithexpose.com`

## HTTP API Endpoints

### Display Connection

#### Connect Display
```http
POST /api/websocket/display/connect
Content-Type: application/json

{
  "device_info": {
    "name": "AndroidEFF",
    "ip_address": "192.168.68.100",
    "mac_address": "AA:BB:CC:DD:EE:FF",
    "app_version": "1.0",
    "os": "Android",
    "version": "12",
    "firmware_version": "12"
  },
  "display_id": 23
}
```

**Response:**
```json
{
  "success": true,
  "message": "Display connected successfully",
  "data": {
    "display_id": 23,
    "connection_code": "YW282",
    "is_reconnection": false
  }
}
```

#### Disconnect Display
```http
POST /api/websocket/display/disconnect
Content-Type: application/json

{
  "display_id": 23,
  "connection_code": "YW282"
}
```

#### Send Heartbeat
```http
POST /api/websocket/display/heartbeat
Content-Type: application/json

{
  "display_id": 23,
  "connection_code": "YW282"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Heartbeat received",
  "data": {
    "display_id": 23,
    "was_offline": false
  }
}
```

#### List Displays
```http
GET /api/websocket/displays
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 23,
      "name": "AndroidEFF",
      "ip_address": "192.168.68.100",
      "mac_address": "AA:BB:CC:DD:EE:FF",
      "connection_code": "YW282",
      "online": true,
      "last_seen_at": "2025-09-01 20:00:57",
      "status": "online"
    }
  ]
}
```

## WebSocket Events

### Client Events (Display → Server)

#### Client Hello
```javascript
{
  "event": "client-hello",
  "data": {
    "display_id": 23,
    "connection_code": "YW282"
  }
}
```

#### Client Device Info
```javascript
{
  "event": "client-device-info",
  "data": {
    "name": "AndroidEFF",
    "ip_address": "192.168.68.100",
    "mac_address": "AA:BB:CC:DD:EE:FF",
    "app_version": "1.0",
    "os": "Android",
    "version": "12",
    "firmware_version": "12"
  }
}
```

### Server Events (Server → Display)

#### Display Code Assignment
```javascript
{
  "event": "display.code",
  "data": {
    "type": "good_day",
    "code": "YW282",
    "display_id": 23,
    "message": "Display connected successfully"
  }
}
```

#### Display Disconnected
```javascript
{
  "event": "display.disconnected",
  "data": {
    "type": "disconnected",
    "display_id": 23,
    "connection_code": "YW282",
    "message": "Display disconnected"
  }
}
```

## Android App Integration

### Connection Flow
1. **Initial Connection**: App connects to WebSocket server
2. **Device Info**: Send device information via HTTP API
3. **Receive Code**: Get connection code via WebSocket event
4. **Heartbeat**: Start sending heartbeats every 30 seconds
5. **Reconnection**: Use stored connection data for reconnections

### JavaScript Client Example
```javascript
class INNSTREAMLauncher {
    constructor() {
        this.baseUrl = 'https://innstream-patienttv.sharedwithexpose.com';
        this.connectionData = this.loadExistingConnectionData();
        this.heartbeatInterval = null;
    }

    async connect() {
        try {
            // Send device info via HTTP API
            const response = await fetch(`${this.baseUrl}/api/websocket/display/connect`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    device_info: {
                        name: "AndroidEFF",
                        ip_address: "192.168.68.100",
                        mac_address: "AA:BB:CC:DD:EE:FF",
                        app_version: "1.0",
                        os: "Android",
                        version: "12",
                        firmware_version: "12"
                    },
                    display_id: this.connectionData?.display_id
                })
            });

            const data = await response.json();
            if (data.success) {
                this.saveConnectionData(data.data);
                this.startHeartbeat();
                console.log('Connected successfully');
            }
        } catch (error) {
            console.error('Connection failed:', error);
        }
    }

    startHeartbeat() {
        if (!this.connectionData?.display_id) return;

        this.heartbeatInterval = setInterval(() => {
            this.sendHeartbeat();
        }, 30000);
    }

    async sendHeartbeat() {
        try {
            const response = await fetch(`${this.baseUrl}/api/websocket/display/heartbeat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    display_id: this.connectionData.display_id,
                    connection_code: this.connectionData.code
                })
            });

            const data = await response.json();
            if (data.success && data.data.was_offline) {
                console.log('Display came back online!');
            }
        } catch (error) {
            console.error('Heartbeat failed:', error);
        }
    }

    saveConnectionData(data) {
        localStorage.setItem('innstream_connection', JSON.stringify(data));
        this.connectionData = data;
    }

    loadExistingConnectionData() {
        const stored = localStorage.getItem('innstream_connection');
        return stored ? JSON.parse(stored) : null;
    }
}
```

## Error Handling

### Common Error Responses
```json
{
  "success": false,
  "message": "Connection failed",
  "error": "Display not found"
}
```

### HTTP Status Codes
- `200`: Success
- `400`: Bad Request
- `401`: Unauthorized
- `404`: Not Found
- `500`: Internal Server Error

### WebSocket Error Handling
- **Connection Lost**: Automatically attempt reconnection
- **Authentication Failed**: Re-authenticate and reconnect
- **Invalid Data**: Log error and continue operation
- **Server Errors**: Retry with exponential backoff

## Security Considerations

### CORS Configuration
The API includes CORS headers to allow cross-origin requests:
- `Access-Control-Allow-Origin: *`
- `Access-Control-Allow-Methods: GET, POST, OPTIONS`
- `Access-Control-Allow-Headers: Content-Type, Accept`

### Authentication
- Connection codes provide device identification
- MAC addresses ensure device uniqueness
- Heartbeat system prevents unauthorized access

### Data Validation
- All input data is validated
- SQL injection protection
- XSS prevention measures

## Monitoring and Logging

### Server Logs
- Connection attempts and results
- Heartbeat activity
- Error conditions and resolutions
- Performance metrics

### Client Logs
- Connection status
- Heartbeat success/failure
- Error conditions
- Performance data

## Troubleshooting

### Connection Issues
- **WebSocket Connection Failed**: Check network connectivity and firewall
- **HTTP API Errors**: Verify URL and authentication
- **CORS Errors**: Ensure proper CORS configuration

### Heartbeat Problems
- **Missing Heartbeats**: Check app is running and connected
- **Late Heartbeats**: Verify network performance
- **Heartbeat Failures**: Check server availability

### Display Status Issues
- **Offline Status**: Verify heartbeat frequency and timeout settings
- **Connection Code Issues**: Check code generation and storage
- **Reconnection Problems**: Verify stored connection data

## Best Practices

### Client Implementation
- **Persistent Storage**: Store connection data in localStorage
- **Automatic Reconnection**: Implement reconnection logic
- **Error Handling**: Handle all error conditions gracefully
- **Performance**: Optimize heartbeat frequency

### Server Configuration
- **Monitoring**: Monitor connection health and performance
- **Logging**: Log all important events and errors
- **Scaling**: Plan for multiple concurrent connections
- **Security**: Implement proper authentication and validation

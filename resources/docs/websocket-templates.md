# WebSocket Template System Documentation

This document describes how displays can use WebSocket connections to check for active templates and receive real-time updates when templates are deployed or removed.

## Overview

The WebSocket template system provides a more efficient alternative to HTTP API calls for displays. Instead of making periodic HTTP requests to check for templates, displays can:

1. **Connect via WebSocket** and receive template information immediately
2. **Receive real-time updates** when templates are deployed or removed
3. **Check for templates** via WebSocket messages without authentication issues
4. **Maintain persistent connection** for instant template updates

## WebSocket Endpoints

### Base URL
```
http://innstream-patienttv.test/api/websocket
```

### Available Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/display/connect` | POST | Connect display and receive template info |
| `/display/disconnect` | POST | Disconnect display |
| `/display/heartbeat` | POST | Send heartbeat to maintain connection |
| `/display/check-template` | POST | Check for active template |
| `/displays` | GET | Get all displays (admin) |

## Connection Flow

### 1. Display Connection

**Endpoint:** `POST /api/websocket/display/connect`

**Request:**
```json
{
  "display_id": 9,
  "connection_code": "8P5Q3",
  "device_info": {
    "name": "Tizen Display",
    "os": "Tizen",
    "app_version": "1.0.0",
    "mac_address": "00:11:22:33:44:55",
    "ip_address": "192.168.1.100"
  }
}
```

**Response:**
```json
{
  "success": true,
  "message": "Display connected successfully",
  "data": {
    "display_id": 9,
    "connection_code": "8P5Q3",
    "is_reconnection": false
  }
}
```

**WebSocket Event Broadcast:**
```json
{
  "type": "good_day",
  "code": "8P5Q3",
  "display_id": 9,
  "message": "Display connected successfully",
  "has_template": true,
  "template": {
    "id": 10,
    "name": "Infocomm",
    "description": "Main Template",
    "category": "healthcare",
    "type": "spa",
    "version": "1.0.0",
    "configuration": null,
    "tags": ["healthcare"],
    "compatibility": ["tv", "tablet"],
    "preview_url": "http://innstream-patienttv.test/templates/10/preview",
    "css_url": "http://innstream-patienttv.test/templates/10/css",
    "js_url": "http://innstream-patienttv.test/templates/10/js",
    "assets_url": "http://innstream-patienttv.test/templates/10/assets",
    "thumbnail_url": "http://innstream-patienttv.test/storage/templates/10/thumbnail/thumbnail-1757271379.png"
  }
}
```

### 2. Template Check

**Endpoint:** `POST /api/websocket/display/check-template`

**Request:**
```json
{
  "display_id": 9,
  "connection_code": "8P5Q3"
}
```

**Response:**
```json
{
  "success": true,
  "has_template": true,
  "template": {
    "id": 10,
    "name": "Infocomm",
    "description": "Main Template",
    "category": "healthcare",
    "type": "spa",
    "version": "1.0.0",
    "configuration": null,
    "tags": ["healthcare"],
    "compatibility": ["tv", "tablet"],
    "preview_url": "http://innstream-patienttv.test/templates/10/preview",
    "css_url": "http://innstream-patienttv.test/templates/10/css",
    "js_url": "http://innstream-patienttv.test/templates/10/js",
    "assets_url": "http://innstream-patienttv.test/templates/10/assets",
    "thumbnail_url": "http://innstream-patienttv.test/storage/templates/10/thumbnail/thumbnail-1757271379.png"
  },
  "display": {
    "id": 9,
    "name": "Tizen0000",
    "connection_code": "8P5Q3",
    "online": true,
    "template_id": 10
  },
  "deployment": {
    "deployed_at": "2025-09-07T19:37:02.000000Z",
    "last_checked": "2025-09-07T19:37:02.358502Z"
  }
}
```

### 3. Heartbeat

**Endpoint:** `POST /api/websocket/display/heartbeat`

**Request:**
```json
{
  "display_id": 9,
  "connection_code": "8P5Q3"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Heartbeat received",
  "data": {
    "display_id": 9,
    "was_offline": false
  }
}
```

## WebSocket Events

### Template Update Event

When a template is deployed or removed, displays receive a real-time WebSocket event:

**Event Name:** `template.update`

**Deploy Event:**
```json
{
  "type": "template_update",
  "display_id": 9,
  "connection_code": "8P5Q3",
  "action": "deploy",
  "timestamp": "2025-09-07T19:37:02.000000Z",
  "has_template": true,
  "template": {
    "id": 10,
    "name": "Infocomm",
    "description": "Main Template",
    "category": "healthcare",
    "type": "spa",
    "version": "1.0.0",
    "configuration": null,
    "tags": ["healthcare"],
    "compatibility": ["tv", "tablet"],
    "preview_url": "http://innstream-patienttv.test/templates/10/preview",
    "css_url": "http://innstream-patienttv.test/templates/10/css",
    "js_url": "http://innstream-patienttv.test/templates/10/js",
    "assets_url": "http://innstream-patienttv.test/templates/10/assets",
    "thumbnail_url": "http://innstream-patienttv.test/storage/templates/10/thumbnail/thumbnail-1757271379.png"
  },
  "message": "Template deployed successfully"
}
```

**Remove Event:**
```json
{
  "type": "template_update",
  "display_id": 9,
  "connection_code": "8P5Q3",
  "action": "remove",
  "timestamp": "2025-09-07T19:37:02.000000Z",
  "has_template": false,
  "message": "Template removed from display"
}
```

## Display Implementation

### JavaScript Example (Tizen/WebOS)

```javascript
class DisplayWebSocketClient {
    constructor(serverUrl, displayId, connectionCode) {
        this.serverUrl = serverUrl;
        this.displayId = displayId;
        this.connectionCode = connectionCode;
        this.isConnected = false;
        this.heartbeatInterval = null;
    }

    async connect() {
        try {
            // Connect to WebSocket endpoint
            const response = await fetch(`${this.serverUrl}/api/websocket/display/connect`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    display_id: this.displayId,
                    connection_code: this.connectionCode,
                    device_info: {
                        name: 'Tizen Display',
                        os: 'Tizen',
                        app_version: '1.0.0',
                        mac_address: this.getMacAddress()
                    }
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.isConnected = true;
                console.log('Connected successfully:', data.data);
                
                // Start heartbeat
                this.startHeartbeat();
                
                // Check for template immediately
                await this.checkTemplate();
            } else {
                console.error('Connection failed:', data.message);
            }
        } catch (error) {
            console.error('Connection error:', error);
        }
    }

    async checkTemplate() {
        try {
            const response = await fetch(`${this.serverUrl}/api/websocket/display/check-template`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    display_id: this.displayId,
                    connection_code: this.connectionCode
                })
            });

            const data = await response.json();
            
            if (data.success) {
                if (data.has_template) {
                    console.log('Template found:', data.template);
                    this.loadTemplate(data.template);
                } else {
                    console.log('No active template');
                    this.clearTemplate();
                }
            } else {
                console.error('Template check failed:', data.message);
            }
        } catch (error) {
            console.error('Template check error:', error);
        }
    }

    async sendHeartbeat() {
        if (!this.isConnected) return;

        try {
            const response = await fetch(`${this.serverUrl}/api/websocket/display/heartbeat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    display_id: this.displayId,
                    connection_code: this.connectionCode
                })
            });

            const data = await response.json();
            
            if (!data.success) {
                console.error('Heartbeat failed:', data.message);
                this.isConnected = false;
            }
        } catch (error) {
            console.error('Heartbeat error:', error);
            this.isConnected = false;
        }
    }

    startHeartbeat() {
        // Send heartbeat every 30 seconds
        this.heartbeatInterval = setInterval(() => {
            this.sendHeartbeat();
        }, 30000);
    }

    loadTemplate(template) {
        // Load template HTML, CSS, and JS
        console.log('Loading template:', template.name);
        
        // Load CSS
        if (template.css_url) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = template.css_url;
            document.head.appendChild(link);
        }

        // Load JS
        if (template.js_url) {
            const script = document.createElement('script');
            script.src = template.js_url;
            document.head.appendChild(script);
        }

        // Load HTML content
        this.loadTemplateContent(template.id);
    }

    async loadTemplateContent(templateId) {
        try {
            const response = await fetch(`${this.serverUrl}/api/display/template/content?template_id=${templateId}&display_id=${this.displayId}`);
            const data = await response.json();
            
            if (data.success) {
                // Inject HTML content
                document.body.innerHTML = data.template.html_content;
                console.log('Template content loaded successfully');
            }
        } catch (error) {
            console.error('Error loading template content:', error);
        }
    }

    clearTemplate() {
        // Clear current template
        document.body.innerHTML = '<div>No active template</div>';
        console.log('Template cleared');
    }

    getMacAddress() {
        // Get device MAC address (implementation depends on platform)
        return '00:11:22:33:44:55';
    }

    disconnect() {
        this.isConnected = false;
        
        if (this.heartbeatInterval) {
            clearInterval(this.heartbeatInterval);
            this.heartbeatInterval = null;
        }

        // Send disconnect request
        fetch(`${this.serverUrl}/api/websocket/display/disconnect`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                connection_code: this.connectionCode
            })
        });
    }
}

// Usage
const displayClient = new DisplayWebSocketClient(
    'http://innstream-patienttv.test',
    9,
    '8P5Q3'
);

// Connect when page loads
document.addEventListener('DOMContentLoaded', () => {
    displayClient.connect();
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    displayClient.disconnect();
});
```

### Python Example

```python
import requests
import time
import threading

class DisplayWebSocketClient:
    def __init__(self, server_url, display_id, connection_code):
        self.server_url = server_url
        self.display_id = display_id
        self.connection_code = connection_code
        self.is_connected = False
        self.heartbeat_thread = None

    def connect(self):
        try:
            response = requests.post(f"{self.server_url}/api/websocket/display/connect", json={
                'display_id': self.display_id,
                'connection_code': self.connection_code,
                'device_info': {
                    'name': 'Python Display',
                    'os': 'Linux',
                    'app_version': '1.0.0',
                    'mac_address': '00:11:22:33:44:55'
                }
            })
            
            data = response.json()
            
            if data['success']:
                self.is_connected = True
                print(f"Connected successfully: {data['data']}")
                
                # Start heartbeat
                self.start_heartbeat()
                
                # Check for template
                self.check_template()
            else:
                print(f"Connection failed: {data['message']}")
                
        except Exception as e:
            print(f"Connection error: {e}")

    def check_template(self):
        try:
            response = requests.post(f"{self.server_url}/api/websocket/display/check-template", json={
                'display_id': self.display_id,
                'connection_code': self.connection_code
            })
            
            data = response.json()
            
            if data['success']:
                if data['has_template']:
                    print(f"Template found: {data['template']['name']}")
                    self.load_template(data['template'])
                else:
                    print("No active template")
                    self.clear_template()
            else:
                print(f"Template check failed: {data['message']}")
                
        except Exception as e:
            print(f"Template check error: {e}")

    def send_heartbeat(self):
        if not self.is_connected:
            return

        try:
            response = requests.post(f"{self.server_url}/api/websocket/display/heartbeat", json={
                'display_id': self.display_id,
                'connection_code': self.connection_code
            })
            
            data = response.json()
            
            if not data['success']:
                print(f"Heartbeat failed: {data['message']}")
                self.is_connected = False
                
        except Exception as e:
            print(f"Heartbeat error: {e}")
            self.is_connected = False

    def start_heartbeat(self):
        def heartbeat_loop():
            while self.is_connected:
                self.send_heartbeat()
                time.sleep(30)  # Send heartbeat every 30 seconds

        self.heartbeat_thread = threading.Thread(target=heartbeat_loop)
        self.heartbeat_thread.daemon = True
        self.heartbeat_thread.start()

    def load_template(self, template):
        print(f"Loading template: {template['name']}")
        # Implementation depends on your display platform
        pass

    def clear_template(self):
        print("Clearing template")
        # Implementation depends on your display platform
        pass

    def disconnect(self):
        self.is_connected = False
        
        try:
            requests.post(f"{self.server_url}/api/websocket/display/disconnect", json={
                'connection_code': self.connection_code
            })
        except Exception as e:
            print(f"Disconnect error: {e}")

# Usage
if __name__ == "__main__":
    client = DisplayWebSocketClient(
        "http://innstream-patienttv.test",
        9,
        "8P5Q3"
    )
    
    client.connect()
    
    try:
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        client.disconnect()
```

## Testing

### WebSocket Test Page

A test page is available at: `http://innstream-patienttv.test/websocket-test.html`

This page allows you to:
- Test display connection
- Check for templates
- Send heartbeats
- View real-time template information
- Monitor WebSocket messages

### Manual Testing

```bash
# Test connection
curl -X POST "http://innstream-patienttv.test/api/websocket/display/connect" \
  -H "Content-Type: application/json" \
  -d '{"display_id": 9, "device_info": {"name": "Test Display", "os": "Tizen"}}'

# Test template check
curl -X POST "http://innstream-patienttv.test/api/websocket/display/check-template" \
  -H "Content-Type: application/json" \
  -d '{"display_id": 9}'

# Test heartbeat
curl -X POST "http://innstream-patienttv.test/api/websocket/display/heartbeat" \
  -H "Content-Type: application/json" \
  -d '{"display_id": 9}'
```

## Benefits of WebSocket Approach

1. **No Authentication Issues**: WebSocket endpoints don't require login
2. **Real-time Updates**: Instant template deployment/removal notifications
3. **Efficient**: Single connection instead of multiple HTTP requests
4. **Persistent**: Connection stays alive for instant updates
5. **Reliable**: Built-in heartbeat mechanism for connection monitoring

## Migration from HTTP API

If you're currently using the HTTP API (`/api/display/template/check`), you can easily migrate to WebSocket:

1. **Replace HTTP calls** with WebSocket connection
2. **Listen for events** instead of polling
3. **Use heartbeat** to maintain connection
4. **Handle reconnection** for reliability

The WebSocket system provides the same functionality as the HTTP API but with better performance and real-time capabilities.

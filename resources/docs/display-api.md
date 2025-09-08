# Display API Documentation

This document describes the API endpoints that displays can use to check for active templates and retrieve content.

## Base URL
```
http://innstream-patienttv.test/api/display
```

## Authentication
These endpoints are **public** and do not require authentication. Displays can call them directly without API keys or tokens.

## Endpoints

### 1. Check for Active Template

**Endpoint:** `GET/POST /api/display/template/check`

**Description:** Check if a display has an active template assigned to it.

**Parameters:**
- `display_id` (optional): Display ID
- `connection_code` (optional): Display connection code
- `mac_address` (optional): Display MAC address

*Note: At least one identifier must be provided.*

**Example Request:**
```bash
curl -X GET "http://innstream-patienttv.test/api/display/template/check?display_id=9"
```

**Example Response (with template):**
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
    "connection_code": "7241S",
    "online": true,
    "template_id": 10
  },
  "deployment": {
    "deployed_at": "2025-09-07T19:21:06.000000Z",
    "last_checked": "2025-09-07T19:21:06.760715Z"
  }
}
```

**Example Response (no template):**
```json
{
  "success": true,
  "has_template": false,
  "message": "No active template for this display",
  "display": {
    "id": 9,
    "name": "Tizen0000",
    "connection_code": "7241S",
    "online": true
  }
}
```

### 2. Get Template Content

**Endpoint:** `GET/POST /api/display/template/content`

**Description:** Retrieve the actual HTML, CSS, and JavaScript content for a template.

**Parameters:**
- `template_id` (required): Template ID
- `display_id` (required): Display ID (for verification)

**Example Request:**
```bash
curl -X GET "http://innstream-patienttv.test/api/display/template/content?template_id=10&display_id=9"
```

**Example Response:**
```json
{
  "success": true,
  "template": {
    "id": 10,
    "name": "Infocomm",
    "html_content": "<!DOCTYPE html>...",
    "css_content": "/* Reset and Base Styles */...",
    "js_content": "// Hotel TV Interface...",
    "configuration": null,
    "assets_url": "http://innstream-patienttv.test/templates/10/assets"
  }
}
```

### 3. Report Display Status

**Endpoint:** `POST /api/display/status`

**Description:** Report display status, capabilities, and system information.

**Parameters:**
- `display_id` (optional): Display ID
- `connection_code` (optional): Display connection code
- `mac_address` (optional): Display MAC address
- `message` (optional): Status message
- `app_version` (optional): Application version
- `os` (optional): Operating system
- `version` (optional): System version
- `firmware_version` (optional): Firmware version
- `capabilities` (optional): Array of display capabilities
- `configuration` (optional): Display configuration object

**Example Request:**
```bash
curl -X POST "http://innstream-patienttv.test/api/display/status" \
  -H "Content-Type: application/json" \
  -d '{
    "display_id": 9,
    "message": "Status update from display",
    "app_version": "1.0.0",
    "os": "Tizen",
    "capabilities": ["video", "audio", "touch"]
  }'
```

**Example Response:**
```json
{
  "success": true,
  "message": "Status updated successfully",
  "display": {
    "id": 9,
    "name": "Tizen0000",
    "connection_code": "7241S",
    "online": true,
    "last_seen_at": "2025-09-07T19:21:20.000000Z"
  }
}
```

### 4. Template Assets

**Endpoint:** `GET /templates/{template_id}/assets/{path?}`

**Description:** Serve template assets (images, fonts, etc.) with proper caching headers.

**Parameters:**
- `template_id`: Template ID
- `path` (optional): Asset path within the template's assets directory

**Example Request:**
```bash
curl -X GET "http://innstream-patienttv.test/templates/10/assets/images/background.jpg"
```

**Response:** Binary file content with appropriate MIME type and caching headers.

## Error Responses

All endpoints return consistent error responses:

**400 Bad Request:**
```json
{
  "success": false,
  "message": "Display identifier required (display_id, connection_code, or mac_address)"
}
```

**404 Not Found:**
```json
{
  "success": false,
  "message": "Display not found"
}
```

**500 Internal Server Error:**
```json
{
  "success": false,
  "message": "Internal server error"
}
```

## Usage Examples

### JavaScript (Tizen/WebOS)
```javascript
// Check for active template
async function checkForTemplate() {
  try {
    const response = await fetch('http://innstream-patienttv.test/api/display/template/check?display_id=9');
    const data = await response.json();
    
    if (data.success && data.has_template) {
      console.log('Template found:', data.template.name);
      // Load the template content
      await loadTemplateContent(data.template.id);
    } else {
      console.log('No active template');
    }
  } catch (error) {
    console.error('Error checking for template:', error);
  }
}

// Load template content
async function loadTemplateContent(templateId) {
  try {
    const response = await fetch(`http://innstream-patienttv.test/api/display/template/content?template_id=${templateId}&display_id=9`);
    const data = await response.json();
    
    if (data.success) {
      // Inject HTML, CSS, and JS into the display
      document.head.innerHTML += `<style>${data.template.css_content}</style>`;
      document.body.innerHTML = data.template.html_content;
      eval(data.template.js_content);
    }
  } catch (error) {
    console.error('Error loading template content:', error);
  }
}

// Report status
async function reportStatus() {
  try {
    const response = await fetch('http://innstream-patienttv.test/api/display/status', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        display_id: 9,
        message: 'Display online',
        app_version: '1.0.0',
        os: 'Tizen',
        capabilities: ['video', 'audio', 'touch']
      })
    });
    
    const data = await response.json();
    console.log('Status reported:', data.message);
  } catch (error) {
    console.error('Error reporting status:', error);
  }
}
```

### Python
```python
import requests
import json

# Check for active template
def check_for_template(display_id):
    url = f"http://innstream-patienttv.test/api/display/template/check"
    params = {"display_id": display_id}
    
    response = requests.get(url, params=params)
    data = response.json()
    
    if data["success"] and data["has_template"]:
        print(f"Template found: {data['template']['name']}")
        return data["template"]
    else:
        print("No active template")
        return None

# Load template content
def load_template_content(template_id, display_id):
    url = f"http://innstream-patienttv.test/api/display/template/content"
    params = {
        "template_id": template_id,
        "display_id": display_id
    }
    
    response = requests.get(url, params=params)
    data = response.json()
    
    if data["success"]:
        return data["template"]
    return None

# Report status
def report_status(display_id, status_data):
    url = f"http://innstream-patienttv.test/api/display/status"
    data = {
        "display_id": display_id,
        **status_data
    }
    
    response = requests.post(url, json=data)
    return response.json()
```

## CORS Support

All API endpoints support CORS and can be called from any origin. The server is configured to accept requests from any domain.

## Rate Limiting

Currently, there is no rate limiting implemented. In production, consider implementing rate limiting to prevent abuse.

## Caching

- Template assets are cached for 1 hour (3600 seconds)
- Template content should be cached by the display client
- Status updates are processed immediately

## Security Considerations

- These endpoints are public and do not require authentication
- Display identification is based on database records
- Template content is only served to displays that have the template assigned
- Asset serving includes basic security checks to prevent directory traversal

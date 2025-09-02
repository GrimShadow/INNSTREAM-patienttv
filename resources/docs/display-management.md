# Display Management

The Display Management system allows you to connect, monitor, and control Android TV displays throughout your facility.

## Overview

Displays are the core component of the INNSTREAM system. Each display represents a physical Android TV device that can receive and display content from your templates and channels.

## Display Status

### Online/Offline Status
- **Online**: Display is connected and sending heartbeats
- **Offline**: Display hasn't sent a heartbeat in the last 60 seconds
- **Connection Code**: 5-character alphanumeric code for device identification

### Status Indicators
- 🟢 **Green**: Display is online and active
- 🔴 **Red**: Display is offline or disconnected
- ⚪ **Gray**: Display has never connected

## Adding a New Display

### Manual Addition
1. Navigate to **Display Management**
2. Click **Add Display**
3. Fill in the required information:
   - **Name**: Descriptive name (e.g., "Room 301 TV")
   - **IP Address**: Network IP of the device
   - **MAC Address**: Hardware identifier (recommended)
   - **Location**: Room number or area
   - **Floor**: Building floor
   - **Room**: Specific room identifier

### Automatic Discovery
Displays are automatically added when they connect via the Android app:
1. Android app connects to server
2. Device information is sent
3. Display appears in management interface
4. Connection code is generated

## Display Information

### Required Fields
- **Name**: Display identifier
- **IP Address**: Network location
- **MAC Address**: Hardware identifier (for reconnection)

### Optional Fields
- **Make/Model**: Device specifications
- **OS Version**: Android version
- **Firmware Version**: Device firmware
- **App Version**: INNSTREAM app version
- **Location**: Physical location details

## Display Controls

### Volume Control
- Adjust volume from 0-100%
- Changes apply immediately to connected displays
- Volume settings persist across sessions

### Brightness Control
- Adjust brightness from 0-100%
- Useful for different lighting conditions
- Settings apply to all connected displays

### Power Management
- **Power On**: Wake up sleeping displays
- **Power Off**: Put displays to sleep
- **Restart**: Reboot the display device

## Monitoring and Maintenance

### Real-time Status
- View online/offline status in real-time
- Monitor last seen timestamps
- Track connection codes and device info

### Heartbeat System
- Displays send heartbeats every 30 seconds
- System marks displays offline after 60 seconds of inactivity
- Automatic reconnection when displays come back online

### Troubleshooting
- **Display Offline**: Check network connectivity
- **Connection Issues**: Verify IP address and firewall settings
- **App Crashes**: Restart the Android app
- **No Heartbeats**: Check if app is running and connected

## Best Practices

### Naming Convention
- Use descriptive names: "Room 301 - Main TV"
- Include location information
- Use consistent formatting

### Network Setup
- Use static IP addresses when possible
- Ensure displays are on the same network as the server
- Configure firewall to allow WebSocket connections

### Maintenance Schedule
- Regularly check display status
- Update Android app when new versions are available
- Monitor system logs for connection issues

## API Integration

The display management system includes a REST API for programmatic access:

- `GET /api/websocket/displays` - List all displays
- `POST /api/websocket/display/connect` - Connect a display
- `POST /api/websocket/display/disconnect` - Disconnect a display
- `POST /api/websocket/display/heartbeat` - Send heartbeat

See [WebSocket API Documentation](./websocket-api.md) for detailed API information.

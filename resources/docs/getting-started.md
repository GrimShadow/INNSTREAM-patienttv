# Getting Started

Welcome to INNSTREAM Patient TV - a comprehensive digital signage and display management system for healthcare facilities.

## Overview

INNSTREAM Patient TV is designed to provide healthcare facilities with an easy-to-use platform for managing digital displays, templates, and content distribution across multiple screens. The system includes:

- **Display Management**: Connect and manage Android TV displays
- **Template System**: Create and customize content templates
- **Channel Management**: Organize and schedule content channels
- **Real-time Monitoring**: Track display status and connectivity
- **WebSocket Communication**: Real-time updates and control

## System Requirements

### Server Requirements
- PHP 8.2 or higher
- Laravel 12
- MySQL 8.0 or higher
- Laravel Reverb (WebSocket server)
- Laravel Herd (for local development)

### Display Requirements
- Android TV device
- Network connectivity
- WebView support
- JavaScript enabled

## Quick Start

### 1. Installation

The application is already set up and running on Laravel Herd. Access it at:
- **Local URL**: `https://innstream-patienttv.test`
- **Expose Tunnel**: `https://innstream-patienttv.sharedwithexpose.com`

### 2. First Login

1. Navigate to the application URL
2. Use the default admin credentials (if available)
3. Or create a new account through the registration process

### 3. Add Your First Display

1. Go to **Display Management** from the dashboard
2. Click **Add Display** button
3. Enter display information:
   - Name (e.g., "Room 301 TV")
   - IP Address
   - MAC Address (recommended)
   - Location details
4. Save the display

### 4. Connect Android TV

1. Install the INNSTREAM Android app on your TV
2. The app will automatically connect to the server
3. You'll receive a 5-character connection code
4. The display will appear in your dashboard

## Next Steps

- [Display Management Guide](./display-management.md)
- [Template Creation](./templates.md)
- [Channel Configuration](./channels.md)
- [WebSocket API](./websocket-api.md)

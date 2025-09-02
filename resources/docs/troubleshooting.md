# Troubleshooting Guide

This guide helps you diagnose and resolve common issues with the INNSTREAM Patient TV system.

## Common Issues

### Display Connection Problems

#### Display Shows as Offline
**Symptoms:**
- Display appears offline in dashboard
- No heartbeat activity
- Connection code not working

**Possible Causes:**
- Android app not running
- Network connectivity issues
- Firewall blocking connections
- App crashed or stopped

**Solutions:**
1. **Check Android App Status**
   - Ensure the INNSTREAM app is running
   - Restart the app if necessary
   - Check for app updates

2. **Verify Network Connection**
   - Test internet connectivity on the display
   - Ping the server from the display
   - Check network settings

3. **Check Firewall Settings**
   - Ensure ports 80/443 are open
   - Allow WebSocket connections
   - Check corporate firewall rules

4. **Restart Display**
   - Power cycle the Android TV
   - Clear app cache and data
   - Reinstall the app if needed

#### Connection Code Issues
**Symptoms:**
- Cannot connect with connection code
- Code appears invalid
- Multiple connection attempts fail

**Solutions:**
1. **Verify Connection Code**
   - Check code is exactly 5 characters
   - Ensure no extra spaces or characters
   - Try regenerating the code

2. **Check Display ID**
   - Verify display ID matches database
   - Check for duplicate entries
   - Clear localStorage and reconnect

3. **Network Issues**
   - Test server connectivity
   - Check DNS resolution
   - Verify server is accessible

### WebSocket Connection Issues

#### WebSocket Connection Failed
**Symptoms:**
- Cannot establish WebSocket connection
- Connection timeout errors
- SSL/TLS handshake failures

**Solutions:**
1. **Check Server Status**
   - Verify Laravel Reverb is running
   - Check server logs for errors
   - Test server connectivity

2. **Network Configuration**
   - Check firewall settings
   - Verify port 443 is open
   - Test with different network

3. **SSL/TLS Issues**
   - Check certificate validity
   - Verify SSL configuration
   - Try HTTP instead of HTTPS for testing

#### Heartbeat Failures
**Symptoms:**
- Displays go offline frequently
- Heartbeat errors in logs
- Inconsistent online status

**Solutions:**
1. **Check Heartbeat Frequency**
   - Verify 30-second interval
   - Check for network delays
   - Monitor heartbeat success rate

2. **Server Performance**
   - Check server load
   - Monitor database performance
   - Review server logs

3. **Network Stability**
   - Test network latency
   - Check for packet loss
   - Verify stable connection

### Template and Content Issues

#### Templates Not Displaying
**Symptoms:**
- Templates don't appear on displays
- Content shows as blank
- Template errors in logs

**Solutions:**
1. **Check Template Status**
   - Verify template is published
   - Check template assignment
   - Review template content

2. **Display Assignment**
   - Confirm template is assigned to display
   - Check assignment schedule
   - Verify display is online

3. **Content Issues**
   - Check image/video file paths
   - Verify file permissions
   - Test content in browser

#### Content Loading Problems
**Symptoms:**
- Slow content loading
- Images not displaying
- Videos not playing

**Solutions:**
1. **Optimize Content**
   - Compress images
   - Use appropriate formats
   - Check file sizes

2. **Network Performance**
   - Test bandwidth
   - Check for network congestion
   - Optimize content delivery

3. **Display Performance**
   - Check display memory usage
   - Clear display cache
   - Restart display if needed

### System Performance Issues

#### Slow Dashboard Loading
**Symptoms:**
- Dashboard takes long to load
- Timeout errors
- Poor user experience

**Solutions:**
1. **Database Optimization**
   - Check database performance
   - Optimize queries
   - Review database indexes

2. **Server Resources**
   - Monitor CPU and memory usage
   - Check disk space
   - Review server logs

3. **Network Issues**
   - Test network speed
   - Check for network congestion
   - Verify server connectivity

#### High Server Load
**Symptoms:**
- Server response delays
- Timeout errors
- System instability

**Solutions:**
1. **Resource Monitoring**
   - Check CPU usage
   - Monitor memory consumption
   - Review disk I/O

2. **Optimization**
   - Optimize database queries
   - Implement caching
   - Review application code

3. **Scaling**
   - Consider server upgrade
   - Implement load balancing
   - Add more resources

## Diagnostic Tools

### Server Logs
**Location:** `storage/logs/laravel.log`

**Key Information:**
- Connection attempts and results
- Heartbeat activity
- Error messages and stack traces
- Performance metrics

**How to Use:**
```bash
# View recent logs
tail -f storage/logs/laravel.log

# Search for specific errors
grep "ERROR" storage/logs/laravel.log

# Monitor WebSocket activity
grep "WebSocket" storage/logs/laravel.log
```

### Database Queries
**Check Display Status:**
```sql
SELECT id, name, online, last_seen_at, connection_code 
FROM displays 
ORDER BY last_seen_at DESC;
```

**Check Heartbeat Activity:**
```sql
SELECT display_id, COUNT(*) as heartbeat_count
FROM display_heartbeats 
WHERE created_at > NOW() - INTERVAL 1 HOUR
GROUP BY display_id;
```

### Network Testing
**Test Server Connectivity:**
```bash
# Test HTTP connection
curl -I https://innstream-patienttv.sharedwithexpose.com

# Test WebSocket connection
wscat -c wss://innstream-patienttv.sharedwithexpose.com

# Test API endpoints
curl -X POST https://innstream-patienttv.sharedwithexpose.com/api/websocket/display/connect
```

## Prevention Strategies

### Regular Maintenance
1. **Monitor System Health**
   - Check display status daily
   - Review server logs weekly
   - Monitor performance metrics

2. **Update Software**
   - Keep Android app updated
   - Update server software
   - Apply security patches

3. **Backup Data**
   - Regular database backups
   - Template and content backups
   - Configuration backups

### Proactive Monitoring
1. **Set Up Alerts**
   - Display offline alerts
   - Server error notifications
   - Performance threshold alerts

2. **Regular Testing**
   - Test display connections
   - Verify content delivery
   - Check system performance

3. **Documentation**
   - Keep troubleshooting notes
   - Document solutions
   - Share knowledge with team

## Getting Help

### Self-Service Resources
- **Documentation**: Check this guide and other docs
- **Logs**: Review server and application logs
- **Community**: Check community forums
- **Knowledge Base**: Search existing solutions

### Contact Support
When contacting support, include:
- **Error Messages**: Exact error text
- **Logs**: Relevant log entries
- **Steps to Reproduce**: How to recreate the issue
- **System Information**: Server and display details
- **Screenshots**: Visual evidence of issues

### Emergency Procedures
1. **Critical Issues**
   - Document the problem
   - Check system status
   - Implement workarounds
   - Contact support immediately

2. **System Outage**
   - Check server status
   - Verify network connectivity
   - Review recent changes
   - Implement emergency procedures

3. **Data Loss**
   - Stop all operations
   - Document what was lost
   - Check backup availability
   - Contact support immediately

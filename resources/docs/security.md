# Security Configuration Guide

## 🔒 CORS Security Implementation

This document outlines the secure CORS configuration implemented for the INNSTREAM Patient TV system.

## ✅ **Secure Configuration Applied**

### **1. Origin-Based Access Control**
- **❌ REMOVED**: `Access-Control-Allow-Origin: *` (allows any website)
- **✅ ADDED**: Specific origin validation with whitelist
- **✅ ADDED**: Pattern matching for hotel network IPs

### **2. Multi-Layer Security**

#### **Layer 1: CORS Middleware**
```php
// Only allows specific origins
$allowedOrigins = [
    'http://localhost:3000',        // Development
    'http://192.168.68.56:8000',   // Your hotel network
    'http://10.0.0.1:8000',        // Private network
    // Add more as needed
];
```

#### **Layer 2: IP Whitelisting** (Production Only)
```php
// Additional IP-based protection
'allowed_ips' => [
    '203.0.113.1',  // Add specific hotel IPs
    '198.51.100.1', // Add more as needed
];
```

#### **Layer 3: Rate Limiting**
```php
// Prevents abuse with throttling
'throttle:api' => '60,1'  // 60 requests per minute
```

### **3. WebSocket Security (Reverb)**
```php
// Specific origins only, no wildcards
'allowed_origins' => [
    'http://192.168.68.56:8000',
    'http://localhost:3000',
    // Add your specific domains
],
```

## 🛡️ **Security Features**

### **✅ Implemented Protections**

1. **Origin Validation**: Only approved domains can make requests
2. **IP Whitelisting**: Additional IP-based protection in production
3. **Rate Limiting**: Prevents API abuse and DoS attacks
4. **Credential Support**: Secure cookie/session handling
5. **Preflight Handling**: Proper OPTIONS request handling
6. **Private Network Support**: Automatic allowance for hotel networks

### **🔧 Configuration Files**

- `config/cors.php` - Main CORS configuration
- `app/Http/Middleware/CorsMiddleware.php` - CORS logic
- `app/Http/Middleware/IpWhitelistMiddleware.php` - IP protection
- `config/reverb.php` - WebSocket security

## 📋 **Setup Instructions**

### **For Development**
1. Add your development URLs to `config/cors.php`
2. Update `allowed_origins` array with your local IPs
3. Test with your Tizen app

### **For Production**
1. **Replace wildcard origins** with your actual domains
2. **Add hotel IP addresses** to `allowed_ips` array
3. **Update Reverb config** with production origins
4. **Enable IP whitelisting** by setting environment to production

### **Example Production Config**
```php
// config/cors.php
'allowed_origins' => [
    'https://yourhotel.com',
    'https://tv.yourhotel.com',
    'http://192.168.1.100:8000',  // Hotel TV network
],

'allowed_ips' => [
    '192.168.1.100',  // Hotel TV IP
    '192.168.1.101',  // Additional TV IPs
    '10.0.1.50',      // Management system IP
],
```

## 🚨 **Security Warnings**

### **❌ NEVER Use These in Production**
```php
// DANGEROUS - Allows any website
'Access-Control-Allow-Origin' => '*'

// DANGEROUS - No IP restrictions
'allowed_origins' => ['*']
```

### **✅ Always Use These in Production**
```php
// SECURE - Specific origins only
'Access-Control-Allow-Origin' => $specificOrigin

// SECURE - IP whitelisting enabled
'allowed_ips' => ['specific', 'ip', 'addresses']
```

## 🔍 **Testing Your Configuration**

### **1. Test CORS Headers**
```bash
curl -H "Origin: http://192.168.68.56:8000" \
     -H "Access-Control-Request-Method: POST" \
     -H "Access-Control-Request-Headers: Content-Type" \
     -X OPTIONS \
     http://your-server.com/api/websocket/display/connect
```

### **2. Test IP Whitelisting**
```bash
# Should work from allowed IP
curl http://your-server.com/api/websocket/display/connect

# Should be blocked from other IPs (in production)
```

### **3. Test Rate Limiting**
```bash
# Make multiple rapid requests
for i in {1..70}; do
  curl http://your-server.com/api/websocket/display/connect
done
# Should be rate limited after 60 requests
```

## 📊 **Monitoring & Logging**

### **Security Events to Monitor**
- Failed CORS requests (wrong origin)
- Blocked IP addresses
- Rate limit violations
- Unusual request patterns

### **Log Configuration**
```php
// Add to your logging config
'security' => [
    'driver' => 'single',
    'path' => storage_path('logs/security.log'),
    'level' => 'info',
],
```

## 🔄 **Regular Security Maintenance**

### **Monthly Tasks**
1. Review allowed origins list
2. Update IP whitelist if needed
3. Check rate limiting effectiveness
4. Review security logs for anomalies

### **When Adding New Devices**
1. Add device IP to `allowed_ips`
2. Add device origin to `allowed_origins`
3. Test connection thoroughly
4. Update documentation

## 📞 **Support**

If you encounter CORS issues:
1. Check the browser console for specific error messages
2. Verify the origin is in your `allowed_origins` list
3. Ensure the IP is in your `allowed_ips` list (production)
4. Check rate limiting isn't blocking legitimate requests

---

**Remember**: Security is an ongoing process. Regularly review and update your configuration as your network and requirements change.

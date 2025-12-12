# Apache Port Configuration Guide (Ports 80 and 443)

## Important Notes
- **Port 80 requires Administrator privileges** - You must run XAMPP Control Panel as Administrator
- **Port 443 (HTTPS) requires SSL certificates** - XAMPP includes self-signed certificates by default

## Step 1: Update Main Apache Configuration

### Edit `C:\xampp\apache\conf\httpd.conf`

1. Open `C:\xampp\apache\conf\httpd.conf` in a text editor (as Administrator)
2. Find the line that says:
   ```
   Listen 8080
   ```
   Change it to:
   ```
   Listen 80
   ```
3. Make sure these lines are uncommented (remove the `#` if present):
   ```
   LoadModule ssl_module modules/mod_ssl.so
   Include conf/extra/httpd-ssl.conf
   ```

### Edit `C:\xampp\apache\conf\extra\httpd-ssl.conf`

1. Open `C:\xampp\apache\conf\extra\httpd-ssl.conf`
2. Find the line that says:
   ```
   Listen 443
   ```
   Make sure it's uncommented (no `#` in front)
3. Verify SSL certificate paths are correct:
   ```
   SSLCertificateFile "C:/xampp/apache/conf/ssl.crt/server.crt"
   SSLCertificateKeyFile "C:/xampp/apache/conf/ssl.key/server.key"
   ```

## Step 2: Update Virtual Host Configuration

### Edit `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

1. Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Remove or comment out any existing VirtualHost entries for port 8080
3. Add the contents from `apache_vhost_80.conf` (for HTTP on port 80)
4. Add the contents from `apache_vhost_443.conf` (for HTTPS on port 443)

Or simply copy the VirtualHost blocks from those files.

## Step 3: Verify Configuration

1. Open Command Prompt as Administrator
2. Navigate to `C:\xampp\apache\bin`
3. Run: `httpd.exe -t`
   - This will check for syntax errors
   - Fix any errors before proceeding

## Step 4: Start Apache

1. **Run XAMPP Control Panel as Administrator** (Right-click → Run as administrator)
2. Stop Apache if it's running
3. Start Apache
4. Check the logs if there are any errors

## Step 5: Test

- HTTP: Open `http://localhost` in your browser
- HTTPS: Open `https://localhost` in your browser
  - You may see a security warning (self-signed certificate) - click "Advanced" → "Proceed to localhost"

## Troubleshooting

### Port 80 is already in use
- Check what's using port 80: `netstat -ano | findstr :80`
- Common culprits: IIS, Skype, other web servers
- Stop the service using port 80 or change its port

### Port 443 is already in use
- Check what's using port 443: `netstat -ano | findstr :443`
- Stop the conflicting service

### Apache won't start
- Check Apache error log: `C:\xampp\apache\logs\error.log`
- Make sure you're running as Administrator
- Verify all paths in configuration files are correct


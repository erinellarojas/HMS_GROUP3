# PowerShell script to help update Apache ports to 80 and 443
# Run this script as Administrator

Write-Host "=== XAMPP Apache Port Configuration Updater ===" -ForegroundColor Cyan
Write-Host ""

# Check if running as Administrator
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
if (-not $isAdmin) {
    Write-Host "WARNING: This script should be run as Administrator!" -ForegroundColor Yellow
    Write-Host "Right-click PowerShell and select 'Run as Administrator'" -ForegroundColor Yellow
    Write-Host ""
}

# Define paths
$apacheConf = "C:\xampp\apache\conf\httpd.conf"
$apacheVhosts = "C:\xampp\apache\conf\extra\httpd-vhosts.conf"
$apacheSSL = "C:\xampp\apache\conf\extra\httpd-ssl.conf"

# Check if files exist
if (-not (Test-Path $apacheConf)) {
    Write-Host "ERROR: Apache configuration file not found at: $apacheConf" -ForegroundColor Red
    Write-Host "Please verify your XAMPP installation path." -ForegroundColor Red
    exit 1
}

Write-Host "Checking current Apache configuration..." -ForegroundColor Green
Write-Host ""

# Check current Listen port in httpd.conf
$httpdContent = Get-Content $apacheConf -Raw
if ($httpdContent -match "Listen\s+(\d+)") {
    $currentPort = $matches[1]
    Write-Host "Current Listen port in httpd.conf: $currentPort" -ForegroundColor Yellow
} else {
    Write-Host "Could not find Listen directive in httpd.conf" -ForegroundColor Yellow
}

# Check if SSL module is loaded
if ($httpdContent -match "#\s*LoadModule ssl_module") {
    Write-Host "SSL module is commented out (disabled)" -ForegroundColor Yellow
} elseif ($httpdContent -match "LoadModule ssl_module") {
    Write-Host "SSL module is enabled" -ForegroundColor Green
} else {
    Write-Host "SSL module not found" -ForegroundColor Yellow
}

# Check if httpd-ssl.conf is included
if ($httpdContent -match "#\s*Include.*httpd-ssl.conf") {
    Write-Host "SSL configuration is commented out (disabled)" -ForegroundColor Yellow
} elseif ($httpdContent -match "Include.*httpd-ssl.conf") {
    Write-Host "SSL configuration is included" -ForegroundColor Green
}

Write-Host ""
Write-Host "=== Instructions ===" -ForegroundColor Cyan
Write-Host ""
Write-Host "To configure Apache for ports 80 and 443:" -ForegroundColor White
Write-Host ""
Write-Host "1. Edit: $apacheConf" -ForegroundColor Yellow
Write-Host "   - Change 'Listen 8080' to 'Listen 80'" -ForegroundColor White
Write-Host "   - Uncomment: LoadModule ssl_module modules/mod_ssl.so" -ForegroundColor White
Write-Host "   - Uncomment: Include conf/extra/httpd-ssl.conf" -ForegroundColor White
Write-Host ""
Write-Host "2. Edit: $apacheVhosts" -ForegroundColor Yellow
Write-Host "   - Remove/comment old VirtualHost *:8080 entries" -ForegroundColor White
Write-Host "   - Add VirtualHost blocks from apache_vhost_80.conf and apache_vhost_443.conf" -ForegroundColor White
Write-Host ""
Write-Host "3. Verify SSL configuration in: $apacheSSL" -ForegroundColor Yellow
Write-Host "   - Ensure 'Listen 443' is uncommented" -ForegroundColor White
Write-Host ""
Write-Host "4. Test configuration:" -ForegroundColor Yellow
Write-Host "   cd C:\xampp\apache\bin" -ForegroundColor White
Write-Host "   .\httpd.exe -t" -ForegroundColor White
Write-Host ""
Write-Host "5. Restart Apache from XAMPP Control Panel (as Administrator)" -ForegroundColor Yellow
Write-Host ""

# Check for port conflicts
Write-Host "=== Port Status ===" -ForegroundColor Cyan
Write-Host ""

$port80 = Get-NetTCPConnection -LocalPort 80 -ErrorAction SilentlyContinue
$port443 = Get-NetTCPConnection -LocalPort 443 -ErrorAction SilentlyContinue

if ($port80) {
    Write-Host "Port 80: IN USE by process $($port80.OwningProcess)" -ForegroundColor Red
    $proc = Get-Process -Id $port80.OwningProcess -ErrorAction SilentlyContinue
    if ($proc) {
        Write-Host "  Process: $($proc.ProcessName)" -ForegroundColor Yellow
    }
} else {
    Write-Host "Port 80: AVAILABLE" -ForegroundColor Green
}

if ($port443) {
    Write-Host "Port 443: IN USE by process $($port443.OwningProcess)" -ForegroundColor Yellow
    $proc = Get-Process -Id $port443.OwningProcess -ErrorAction SilentlyContinue
    if ($proc) {
        Write-Host "  Process: $($proc.ProcessName)" -ForegroundColor Yellow
    }
} else {
    Write-Host "Port 443: AVAILABLE" -ForegroundColor Green
}

Write-Host ""
Write-Host "Done!" -ForegroundColor Green


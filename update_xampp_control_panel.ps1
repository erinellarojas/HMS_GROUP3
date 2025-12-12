# PowerShell script to update XAMPP Control Panel Apache ports to 80 and 443
# Run this script as Administrator

Write-Host "=== XAMPP Control Panel Port Configuration Updater ===" -ForegroundColor Cyan
Write-Host ""

# Check if running as Administrator
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
if (-not $isAdmin) {
    Write-Host "WARNING: This script should be run as Administrator!" -ForegroundColor Yellow
    Write-Host "Right-click PowerShell and select 'Run as Administrator'" -ForegroundColor Yellow
    Write-Host ""
}

# Define path to XAMPP Control Panel configuration
$controlPanelConfig = "C:\xampp\xampp-control.ini"

# Check if file exists
if (-not (Test-Path $controlPanelConfig)) {
    Write-Host "ERROR: XAMPP Control Panel configuration file not found at: $controlPanelConfig" -ForegroundColor Red
    Write-Host "Please verify your XAMPP installation path." -ForegroundColor Red
    exit 1
}

Write-Host "Reading current configuration..." -ForegroundColor Green
$configContent = Get-Content $controlPanelConfig

# Find the ServicePorts section and get current Apache port settings
$inServicePorts = $false
$apachePort = $null
$apacheSSLPort = $null

foreach ($line in $configContent) {
    if ($line -match "^\[ServicePorts\]") {
        $inServicePorts = $true
    }
    elseif ($line -match "^\[") {
        $inServicePorts = $false
    }
    elseif ($inServicePorts) {
        if ($line -match "^Apache=(\d+)$") {
            $apachePort = $matches[1]
        }
        elseif ($line -match "^ApacheSSL=(\d+)$") {
            $apacheSSLPort = $matches[1]
        }
    }
}

Write-Host ""
Write-Host "Current Configuration:" -ForegroundColor Yellow
Write-Host "  Apache Port: $apachePort" -ForegroundColor $(if ($apachePort -eq "80") { "Green" } else { "Red" })
Write-Host "  Apache SSL Port: $apacheSSLPort" -ForegroundColor $(if ($apacheSSLPort -eq "443") { "Green" } else { "Red" })
Write-Host ""

# Update the configuration
$needsUpdate = $false
$newConfig = @()
$inServicePorts = $false

foreach ($line in $configContent) {
    if ($line -match "^\[ServicePorts\]") {
        $inServicePorts = $true
        $newConfig += $line
    }
    elseif ($line -match "^\[") {
        $inServicePorts = $false
        $newConfig += $line
    }
    elseif ($inServicePorts -and $line -match "^Apache=(\d+)$") {
        if ($matches[1] -ne "80") {
            $newConfig += "Apache=80"
            $needsUpdate = $true
            Write-Host "Updating Apache port from $($matches[1]) to 80" -ForegroundColor Yellow
        } else {
            $newConfig += $line
        }
    }
    elseif ($inServicePorts -and $line -match "^ApacheSSL=(\d+)$") {
        if ($matches[1] -ne "443") {
            $newConfig += "ApacheSSL=443"
            $needsUpdate = $true
            Write-Host "Updating Apache SSL port from $($matches[1]) to 443" -ForegroundColor Yellow
        } else {
            $newConfig += $line
        }
    }
    else {
        $newConfig += $line
    }
}

if ($needsUpdate) {
    Write-Host ""
    Write-Host "Backing up original configuration..." -ForegroundColor Yellow
    $backupPath = "$controlPanelConfig.backup_$(Get-Date -Format 'yyyyMMdd_HHmmss')"
    Copy-Item $controlPanelConfig $backupPath
    Write-Host "Backup saved to: $backupPath" -ForegroundColor Green
    
    Write-Host ""
    Write-Host "Updating configuration file..." -ForegroundColor Yellow
    $newConfig | Set-Content $controlPanelConfig -Encoding UTF8
    
    Write-Host ""
    Write-Host "Configuration updated successfully!" -ForegroundColor Green
    Write-Host ""
    Write-Host "IMPORTANT: Close and restart XAMPP Control Panel for changes to take effect." -ForegroundColor Cyan
} else {
    Write-Host "Configuration is already correct (Apache=80, ApacheSSL=443)" -ForegroundColor Green
    Write-Host "No changes needed." -ForegroundColor Green
}

Write-Host ""
Write-Host "=== Verification ===" -ForegroundColor Cyan
$updatedConfig = Get-Content $controlPanelConfig
$inServicePorts = $false
$updatedApachePort = $null
$updatedApacheSSLPort = $null

foreach ($line in $updatedConfig) {
    if ($line -match "^\[ServicePorts\]") {
        $inServicePorts = $true
    }
    elseif ($line -match "^\[") {
        $inServicePorts = $false
    }
    elseif ($inServicePorts) {
        if ($line -match "^Apache=(\d+)$") {
            $updatedApachePort = $matches[1]
        }
        elseif ($line -match "^ApacheSSL=(\d+)$") {
            $updatedApacheSSLPort = $matches[1]
        }
    }
}

Write-Host "  Apache Port: $updatedApachePort" -ForegroundColor $(if ($updatedApachePort -eq "80") { "Green" } else { "Red" })
Write-Host "  Apache SSL Port: $updatedApacheSSLPort" -ForegroundColor $(if ($updatedApacheSSLPort -eq "443") { "Green" } else { "Red" })

Write-Host ""
Write-Host "Done!" -ForegroundColor Green


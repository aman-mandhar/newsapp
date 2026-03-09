Write-Host "`nImageMagick Setup for Laragon" -ForegroundColor Cyan
Write-Host "==============================`n" -ForegroundColor Cyan

# Check if ImageMagick is installed
$imagickPath = "C:\ImageMagick"
if (Test-Path $imagickPath) {
    Write-Host "✓ ImageMagick found at: $imagickPath" -ForegroundColor Green

    # Add to system PATH (requires admin)
    Write-Host "`nAdding ImageMagick to PATH (requires admin privileges)..." -ForegroundColor Yellow

    if (-NOT ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")) {
        Write-Host "`n⚠ Please run PowerShell as Administrator to add to PATH" -ForegroundColor Red
        Write-Host "Or manually add this to your System PATH:" -ForegroundColor Yellow
        Write-Host "  $imagickPath" -ForegroundColor White
    } else {
        $currentPath = [Environment]::GetEnvironmentVariable("Path", "Machine")
        if ($currentPath -notlike "*$imagickPath*") {
            [Environment]::SetEnvironmentVariable("Path", "$currentPath;$imagickPath", "Machine")
            Write-Host "✓ Added to PATH successfully!" -ForegroundColor Green
        } else {
            Write-Host "✓ Already in PATH" -ForegroundColor Green
        }
    }
} else {
    Write-Host "✗ ImageMagick NOT found at: $imagickPath" -ForegroundColor Red
    Write-Host "`nPlease download and install from:" -ForegroundColor Yellow
    Write-Host "  https://imagemagick.org/script/download.php#windows" -ForegroundColor White
    Write-Host "`nGet: ImageMagick-7.x.x-Q16-HDRI-x64-dll.exe" -ForegroundColor White
    Write-Host "Install to: C:\ImageMagick (recommended)" -ForegroundColor White
}

Write-Host "`n3. RESTART LARAGON after adding to PATH" -ForegroundColor Yellow
Write-Host "4. Verify with: php -m | Select-String imagick" -ForegroundColor Yellow
Write-Host ""

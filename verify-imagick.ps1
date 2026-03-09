Write-Host "`nVerifying Imagick Installation..." -ForegroundColor Cyan
Write-Host "================================`n" -ForegroundColor Cyan

if (php -m | Select-String "imagick") {
    Write-Host " Imagick is INSTALLED and LOADED!" -ForegroundColor Green
    php -r "echo 'Version: ' . Imagick::getVersion()['versionString'] . PHP_EOL;"
    Write-Host "`nYou can now run: php artisan queue:work" -ForegroundColor Yellow
} else {
    Write-Host " Imagick is NOT loaded" -ForegroundColor Red
    Write-Host "`nTroubleshooting:" -ForegroundColor Yellow
    Write-Host "1. Check if php_imagick.dll exists in ext folder" -ForegroundColor White
    Write-Host "2. Check if DLL files are in PHP root folder" -ForegroundColor White
    Write-Host "3. Verify 'extension=imagick' is in php.ini" -ForegroundColor White
    Write-Host "4. Make sure you restarted Laragon" -ForegroundColor White
}

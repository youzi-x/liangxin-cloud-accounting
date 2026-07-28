$ErrorActionPreference = "Stop"

$workspace = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path
$phpExe = Join-Path $workspace "bin\php\php.exe"
$publicDir = Join-Path $PSScriptRoot "public"
$router = Join-Path $PSScriptRoot "router.php"

powershell -NoProfile -ExecutionPolicy Bypass -File (Join-Path $PSScriptRoot "start-mysql.ps1")

$webConn = Get-NetTCPConnection -LocalAddress 127.0.0.1 -LocalPort 8788 -State Listen -ErrorAction SilentlyContinue
if (-not $webConn) {
    Start-Process -FilePath $phpExe `
        -ArgumentList @("-S", "127.0.0.1:8788", "-t", $publicDir, $router) `
        -WorkingDirectory $workspace `
        -WindowStyle Hidden `
        -RedirectStandardOutput (Join-Path $PSScriptRoot "server.out.log") `
        -RedirectStandardError (Join-Path $PSScriptRoot "server.err.log")
    Start-Sleep -Seconds 1
}

Write-Host "Local finance system: http://127.0.0.1:8788/"

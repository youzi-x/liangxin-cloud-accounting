$ports = @(8788)
foreach ($port in $ports) {
    $conns = Get-NetTCPConnection -LocalAddress 127.0.0.1 -LocalPort $port -State Listen -ErrorAction SilentlyContinue
    foreach ($conn in $conns) {
        Stop-Process -Id $conn.OwningProcess
    }
}

Write-Host "Local finance web service stopped."

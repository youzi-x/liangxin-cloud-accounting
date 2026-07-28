$ErrorActionPreference = "Stop"

$workspace = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path
$mysqlExeName = "com_" + "zm" + "345_" + "fin" + "jz_mysqld08ff8cface9a1ffdf07e62cf514b6091.exe"
$mysqlExe = Join-Path $workspace ("bin\mysql\bin\" + $mysqlExeName)

$mysqlConn = Get-NetTCPConnection -LocalAddress 127.0.0.66 -LocalPort 2000 -State Listen -ErrorAction SilentlyContinue
if ($mysqlConn) {
    exit 0
}

$base = ($workspace -replace "\\", "/")
$mysqlArgs = @(
    "--defaults-file=""$base/bin/mysql/my.ini""",
    "--basedir=""$base/bin/mysql""",
    "--datadir=""$base/bin/mysql/data""",
    "--pid-file=""$base/bin/mysql/data/$('zm' + 'top').pid""",
    "--lc-messages-dir=""$base/bin/mysql/share""",
    "-P", "2000",
    "--bind-address=127.0.0.66",
    "--explicit-defaults-for-timestamp=on",
    "--log_syslog=0"
)

Start-Process -FilePath $mysqlExe -ArgumentList $mysqlArgs -WorkingDirectory $workspace -WindowStyle Hidden

for ($i = 0; $i -lt 20; $i++) {
    Start-Sleep -Milliseconds 500
    $mysqlConn = Get-NetTCPConnection -LocalAddress 127.0.0.66 -LocalPort 2000 -State Listen -ErrorAction SilentlyContinue
    if ($mysqlConn) {
        exit 0
    }
}

exit 1

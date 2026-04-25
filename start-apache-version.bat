@echo off
setlocal

set "PROJECT_DIR=%~dp0"
if "%PROJECT_DIR:~-1%"=="\" set "PROJECT_DIR=%PROJECT_DIR:~0,-1%"

set "XAMPP_DIR=C:\xampp"
set "PROJECT_NAME=study-trip-management"
set "HTDOCS_LINK=%XAMPP_DIR%\htdocs\%PROJECT_NAME%"

echo ==========================================
echo   Starting Apache version of the project
echo ==========================================
echo.

if not exist "%XAMPP_DIR%\apache\bin\httpd.exe" (
    echo XAMPP Apache was not found in %XAMPP_DIR%.
    pause
    exit /b 1
)

if not exist "%HTDOCS_LINK%" (
    echo Creating htdocs junction...
    mklink /J "%HTDOCS_LINK%" "%PROJECT_DIR%"
) else (
    echo htdocs path already available:
    echo %HTDOCS_LINK%
)

powershell -NoProfile -ExecutionPolicy Bypass -Command "if (-not (Get-Process mysqld -ErrorAction SilentlyContinue)) { Start-Process -FilePath 'C:\xampp\mysql\bin\mysqld.exe' -ArgumentList '--defaults-file=C:\xampp\mysql\bin\my.ini' -WorkingDirectory 'C:\xampp\mysql\bin' -WindowStyle Hidden | Out-Null }"

powershell -NoProfile -ExecutionPolicy Bypass -Command "if (-not (Get-Process httpd -ErrorAction SilentlyContinue)) { Start-Process -FilePath 'C:\xampp\apache\bin\httpd.exe' -WorkingDirectory 'C:\xampp\apache\bin' -WindowStyle Hidden | Out-Null }"

echo.
echo The site should now be available at:
echo http://localhost/%PROJECT_NAME%/public/index.php
echo.
start "" "http://localhost/%PROJECT_NAME%/public/index.php"

endlocal

@echo off
setlocal
setlocal EnableDelayedExpansion

set "PROJECT_DIR=%~dp0"
if "%PROJECT_DIR:~-1%"=="\" set "PROJECT_DIR=%PROJECT_DIR:~0,-1%"

set "XAMPP_DIR=C:\xampp"
set "PROJECT_NAME=study-trip-management"
set "HTDOCS_LINK=%XAMPP_DIR%\htdocs\%PROJECT_NAME%"
set "MYSQL_EXE=%XAMPP_DIR%\mysql\bin\mysql.exe"
set "MYSQLADMIN_EXE=%XAMPP_DIR%\mysql\bin\mysqladmin.exe"
set "MYSQLD_EXE=%XAMPP_DIR%\mysql\bin\mysqld.exe"
set "HTTPD_EXE=%XAMPP_DIR%\apache\bin\httpd.exe"
set "DB_NAME=gestion_voyages_etudes"
set "SCHEMA_FILE=%PROJECT_DIR%\database\schema.sql"
set "SEED_FILE=%PROJECT_DIR%\database\seed.sql"
set "DB_CHECK_FILE=%TEMP%\%PROJECT_NAME%-db-check.txt"

echo ==========================================
echo   Starting Apache version of the project
echo ==========================================
echo.

if not exist "%HTTPD_EXE%" (
    echo XAMPP Apache was not found in %XAMPP_DIR%.
    pause
    exit /b 1
)

if not exist "%MYSQL_EXE%" (
    echo XAMPP MySQL client was not found in %XAMPP_DIR%.
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

echo.
echo Checking MySQL...
powershell -NoProfile -ExecutionPolicy Bypass -Command "if (-not (Get-Process mysqld -ErrorAction SilentlyContinue)) { Start-Process -FilePath 'C:\xampp\mysql\bin\mysqld.exe' -ArgumentList '--defaults-file=C:\xampp\mysql\bin\my.ini' -WorkingDirectory 'C:\xampp\mysql\bin' -WindowStyle Hidden | Out-Null }"

for /L %%I in (1,1,15) do (
    "%MYSQLADMIN_EXE%" -u root ping >nul 2>&1 && goto mysql_ready
    timeout /t 1 >nul
)

echo MySQL did not become ready in time.
pause
exit /b 1

:mysql_ready
echo MySQL is ready.

set "DB_EXISTS="
"%MYSQL_EXE%" -N -B -u root -e "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME='%DB_NAME%';" > "%DB_CHECK_FILE%" 2>nul
set /p DB_EXISTS=<"%DB_CHECK_FILE%" 2>nul

if not defined DB_EXISTS (
    echo Importing database schema...
    type "%SCHEMA_FILE%" | "%MYSQL_EXE%" -u root
    if errorlevel 1 (
        echo Schema import failed.
        pause
        exit /b 1
    )
) else (
    echo Database %DB_NAME% already exists.
)

set "USERS_TABLE_EXISTS="
"%MYSQL_EXE%" -N -B -u root -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='%DB_NAME%' AND table_name='users';" > "%DB_CHECK_FILE%" 2>nul
set /p USERS_TABLE_EXISTS=<"%DB_CHECK_FILE%" 2>nul

if not "!USERS_TABLE_EXISTS!"=="1" (
    echo Users table is missing. Re-importing schema...
    type "%SCHEMA_FILE%" | "%MYSQL_EXE%" -u root
    if errorlevel 1 (
        echo Schema repair failed.
        pause
        exit /b 1
    )
)

set "USER_COUNT=0"
"%MYSQL_EXE%" -N -B -u root -D %DB_NAME% -e "SELECT COUNT(*) FROM users;" > "%DB_CHECK_FILE%" 2>nul
set /p USER_COUNT=<"%DB_CHECK_FILE%" 2>nul

if "!USER_COUNT!"=="0" (
    echo Importing demo data...
    type "%SEED_FILE%" | "%MYSQL_EXE%" -u root
    if errorlevel 1 (
        echo Demo data import failed.
        pause
        exit /b 1
    )
) else (
    echo Existing application data detected. Skipping seed import.
)

echo.
echo Checking Apache...
powershell -NoProfile -ExecutionPolicy Bypass -Command "if (-not (Get-Process httpd -ErrorAction SilentlyContinue)) { Start-Process -FilePath 'C:\xampp\apache\bin\httpd.exe' -WorkingDirectory 'C:\xampp\apache\bin' -WindowStyle Hidden | Out-Null }"

timeout /t 2 >nul

echo.
echo The site should now be available at:
echo http://localhost/%PROJECT_NAME%/public/index.php
echo.
start "" "http://localhost/%PROJECT_NAME%/public/index.php"

del "%DB_CHECK_FILE%" >nul 2>&1

endlocal

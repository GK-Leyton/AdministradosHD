@echo off
setlocal

:: Configuración de las variables
set "MYSQL_DIR=C:\xampp\mysql\bin"
set "BACKUP_DIR=C:\xampp\htdocs\Respaldos\RespaldosBD"
set "DB_NAME=administradordeudas"
set "DB_USER=root"
set "DB_PASS="  :: Sin contraseña

:: Obtener la fecha actual en formato YYYY-MM-DD
for /f "tokens=2 delims==" %%I in ('"wmic os get localdatetime /value"') do set datetime=%%I
set "YYYY=%datetime:~0,4%"
set "MM=%datetime:~4,2%"
set "DD=%datetime:~6,2%"
set "current_date=%YYYY%-%MM%-%DD%"

:: Crear el nombre del archivo de respaldo
set "backup_file=%BACKUP_DIR%\Respaldo-%current_date%.sql"

:: Crear el directorio de respaldo si no existe
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

:: Realizar el respaldo de la base de datos
if "%DB_PASS%"=="" (
    "%MYSQL_DIR%\mysqldump.exe" -u %DB_USER% %DB_NAME% > "%backup_file%"
) else (
    "%MYSQL_DIR%\mysqldump.exe" -u %DB_USER% -p%DB_PASS% %DB_NAME% > "%backup_file%"
)

:: Verificar si el respaldo fue exitoso
if %ERRORLEVEL% EQU 0 (
    echo Respaldo exitoso: %backup_file%
) else (
    echo Error al realizar el respaldo de la base de datos.
    exit /b 1
)

:: Ejecutar el script PHP
"C:\xampp\php\php.exe" -f "C:\xampp\htdocs\AdministradosHD\Controlador\CorreoRespaldoAPP.php"

:: Verificar si el script PHP fue exitoso
if errorlevel 1 (
    echo Error al ejecutar el script PHP.
    exit /b 1
)

echo Respaldo y ejecución del script PHP completados con éxito.


:: Fin del script
endlocal

@echo off
set "source_folder=C:\xampp\htdocs\AdministradosHD"
set "destination_folder=C:\xampp\htdocs\Respaldos\RespaldosAPP"

:: Obtener la fecha actual en formato YYYY-MM-DD
for /f "tokens=2 delims==" %%I in ('"wmic os get localdatetime /value"') do set datetime=%%I
set "YYYY=%datetime:~0,4%"
set "MM=%datetime:~4,2%"
set "DD=%datetime:~6,2%"
set "current_date=%YYYY%-%MM%-%DD%"

:: Crear el nombre del archivo de respaldo
set "destination_7z=%destination_folder%\Respaldo-%current_date%.7z"

:: Comprimir archivos con 7-Zip
"C:\Program Files\7-Zip\7z.exe" a -t7z "%destination_7z%" "%source_folder%\*"

echo Comprimido exitosamente en %destination_7z%





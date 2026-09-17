@echo off
setlocal enabledelayedexpansion

echo ===============================================
echo   Instalador automatico - CRUD PHP
echo ===============================================

REM --- configuracion ---
set DB_NAME=crud_db
set DB_USER=root
set DB_PASS=
set SQL_FILE=crud_db.sql

REM --- buscar mysql.exe de XAMPP ---
set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe

if not exist "%MYSQL_PATH%" (
    echo No se encontro mysql.exe en %MYSQL_PATH%
    echo Verificar que XAMPP este instalado en C:\xampp
    echo Si esta en otra ruta, edita la variable MYSQL_PATH en este script.
    pause
    exit /b 1
)

if not exist "%SQL_FILE%" (
    echo No se encontro el archivo %SQL_FILE% en esta carpeta.
    echo Coloca el dump de la base de datos junto a este script.
    pause
    exit /b 1
)

echo.
echo Creando base de datos "%DB_NAME%" si no existe...
"%MYSQL_PATH%" -u%DB_USER% -e "CREATE DATABASE IF NOT EXISTS %DB_NAME% CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

if %errorlevel% neq 0 (
    echo Error al crear la base de datos. Verifica que XAMPP - MySQL este iniciado.
    pause
    exit /b 1
)

echo Importando %SQL_FILE% a "%DB_NAME%"...
"%MYSQL_PATH%" -u%DB_USER% %DB_NAME% < %SQL_FILE%

if %errorlevel% neq 0 (
    echo Error al importar la base de datos.
    pause
    exit /b 1
)

echo.
echo Base de datos importada correctamente.
echo.
echo Copia (o mueve) esta carpeta del proyecto a C:\xampp\htdocs\
echo Luego abre http://localhost/crud-php en el navegador.
echo.
echo Asegurate de que Apache y MySQL esten iniciados desde el panel de XAMPP.
echo ===============================================
pause

#!/bin/bash
set -e

echo "==============================================="
echo "   Instalador automatico - CRUD PHP"
echo "==============================================="

# --- configuracion ---
DB_NAME="crud_db"
DB_USER="root"
DB_PASS=""
SQL_FILE="crud_db.sql"

# --- verificar que mysql este instalado ---
if ! command -v mysql &> /dev/null; then
    echo "No se encontro el comando 'mysql'."
    echo "Instalalo con: sudo apt install mysql-server mysql-client"
    echo "(o mariadb-server si usas MariaDB)"
    exit 1
fi

if [ ! -f "$SQL_FILE" ]; then
    echo "No se encontro el archivo $SQL_FILE en esta carpeta."
    echo "Coloca el dump de la base de datos junto a este script."
    exit 1
fi

echo ""
echo "Creando base de datos \"$DB_NAME\" si no existe..."
if [ -z "$DB_PASS" ]; then
    mysql -u"$DB_USER" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
else
    mysql -u"$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
fi

echo "Importando $SQL_FILE a \"$DB_NAME\"..."
if [ -z "$DB_PASS" ]; then
    mysql -u"$DB_USER" "$DB_NAME" < "$SQL_FILE"
else
    mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$SQL_FILE"
fi

echo ""
echo "Base de datos importada correctamente."
echo ""
echo "Levantando servidor PHP en http://localhost:8000 ..."
echo "(Presiona Ctrl+C para detenerlo)"
php -S localhost:8000

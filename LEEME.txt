
# Crud con PHP

Crud de PHP con login y roles de usuarios basico.


## Herramientas usadas

- PHP
- Tailwind CSS
- DatataBles

## Caracteristicas
- Los usuarios de tipo "Admin" tienen acceso total a todo el crud
- Los usuarios de "Ventas" pueden ver la seccion de clientes pero no la de usuarios
- Los usuarios de "Finanzas" solo pueden ver la informacion de los clientes
## Credenciales

Para poder acceder a este crud las credenciales son las siguientes:

Admin: 
`admin@correo.com` `admin123`

Ventas: 
`ventas@correo.com` `ventas123`

Finanzas: 
`finanzas@correo.com` `fin123`


## Instalacion

Para poder usar este proyecto se tiene que colocar en la carpeta:
```bash
   C:\xampp\htdocs
```
en caso de usar XAMPP.

Para linux colocar en:
```bash
   /var/www/
```

El proyecto tiene un archivo de configuracion
```bash
   setup.bat
```
para windows al ejecutar este archivo se importara la base de datos automaticamente, senecesita tener el servicio de SQL iniciado.

Y para linux tiene el archivo:
```bash
   setup.sh
```
Para poder ejecutar se le da permisos con chmod +x setup.sh y se ejecuta con ./setup.sh. este levanta el servidor con php -S localhost:8000.

NOTA: En caso de que los scripts de Instalacion no fuincionen se tendra que importar manualmente el archivo "crud_db.sql" a la base de datos.

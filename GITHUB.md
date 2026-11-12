# Publicar este proyecto en GitHub

## Importante
Este proyecto utiliza PHP y MySQL. GitHub almacena el codigo, pero GitHub Pages no ejecuta PHP ni aloja MySQL. Para usarlo en internet se necesita un hosting compatible con PHP y MySQL.

## Subida recomendada
1. Crear un repositorio **privado** en GitHub.
2. Subir el contenido de esta carpeta (no la carpeta ZIP).
3. No subir comprobantes reales, datos personales, contraseñas ni respaldos de la base de datos.
4. Mantener `config/database.php` con credenciales locales/de desarrollo solamente. En el hosting, configurar credenciales seguras y un usuario MySQL propio; nunca usar la cuenta root.
5. Importar `database.sql` en la base de datos del servidor y configurar la conexion.
6. Ejecutar `setup.php` solo durante la instalacion inicial y eliminarlo inmediatamente despues de crear el administrador.

## Instalacion local
Consulta `README.txt` para los requisitos e instrucciones con XAMPP.

SISTEMA INTEGRAL DE TESORERÍA – IESTP UTCUBAMBA
Versión de desarrollo funcional – 2026

REQUISITOS
- XAMPP (Apache + MySQL/MariaDB)
- PHP 8.1+ con PDO MySQL y Fileinfo habilitados
- MySQL 8 o MariaDB compatible

INSTALACIÓN LOCAL
1. Descomprimir la carpeta tesoreria_iestp_utcubamba dentro de C:\xampp\htdocs\
2. Iniciar Apache y MySQL desde XAMPP.
3. Abrir phpMyAdmin y ejecutar database.sql.
4. Revisar config/database.php y ajustar host, base, usuario y contraseña de MySQL.
5. Abrir http://localhost/tesoreria_iestp_utcubamba/setup.php
6. Crear el primer administrador (contraseña mínima de 10 caracteres).
7. Eliminar setup.php inmediatamente después de crear el administrador.
8. Ingresar desde http://localhost/tesoreria_iestp_utcubamba/login.php

FUNCIONES IMPLEMENTADAS
- Inicio y cierre de sesión con contraseñas hash.
- Dashboard con ingresos y egresos confirmados, saldo neto y cantidad de movimientos.
- Registro de ingresos y egresos en estado PENDIENTE.
- Confirmación de movimientos por administrador/tesorero.
- Anulación justificada por administrador, sin borrar el registro.
- Gestión de comprobantes vinculados a movimientos: Boleta, Factura, Recibo, Voucher, etc.
- Adjuntar PDF/JPG/JPEG/PNG (máximo 8 MB), validar MIME y evitar duplicados por tipo/número.
- Búsqueda de comprobantes por número, tipo, concepto o referencia.
- Administración de usuarios, roles, activación/desactivación y restablecimiento de contraseña.
- Auditoría de creación, confirmación, anulación y operaciones de usuario.
- Consultas preparadas PDO, validación CSRF en formularios de operaciones y escape HTML.

ROLES
- administrador: gestión de usuarios, confirmación y anulación, comprobantes y movimientos.
- tesorero: registrar y confirmar movimientos, registrar comprobantes.
- consulta: consultar dashboard, movimientos y comprobantes.

IMPORTANTE
- Los movimientos PENDIENTES y ANULADOS no afectan los totales del dashboard.
- Solo CONFIRMADO se contabiliza.
- Las evidencias se guardan en uploads/comprobantes con nombre aleatorio. En producción configura el servidor para impedir ejecución de scripts en esa carpeta y limita el acceso según la política institucional.
- Configura HTTPS, copias de seguridad de MySQL y permisos del sistema operativo antes de publicar.
- No subas credenciales reales, archivos de comprobantes, datos personales ni respaldos de producción a un repositorio público de GitHub.
- setup.php debe eliminarse luego de crear el primer administrador.
- Esta versión no reemplaza un sistema contable oficial ni está integrada con SIAF. Antes de operar fondos reales, valida procedimientos, permisos, respaldos y controles con el área responsable.

ESTADO DE ALCANCE
Esta entrega completa los flujos base de movimientos, comprobantes y usuarios. Los módulos avanzados de bancos/conciliación, presupuesto, proveedores, cierres de caja y reportes descargables aún requieren desarrollo y validación institucional; las tablas iniciales de caja/cuentas no equivalen a esos procesos completos.

CREATE DATABASE IF NOT EXISTS tesoreria_iestp_utcubamba
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tesoreria_iestp_utcubamba;

CREATE TABLE IF NOT EXISTS usuarios (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  usuario VARCHAR(60) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('administrador','tesorero','consulta') NOT NULL DEFAULT 'consulta',
  estado TINYINT(1) NOT NULL DEFAULT 1,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  tipo ENUM('INGRESO','EGRESO') NOT NULL,
  descripcion VARCHAR(255) NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY uq_categoria_tipo (nombre,tipo)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cuentas_bancarias (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  banco VARCHAR(100) NOT NULL,
  tipo_cuenta VARCHAR(60) NOT NULL,
  moneda CHAR(3) NOT NULL DEFAULT 'PEN',
  numero_enmascarado VARCHAR(40) NOT NULL,
  titular VARCHAR(150) NOT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS movimientos (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tipo ENUM('INGRESO','EGRESO') NOT NULL,
  fecha DATE NOT NULL,
  concepto VARCHAR(250) NOT NULL,
  referencia VARCHAR(100) NULL,
  monto DECIMAL(12,2) NOT NULL,
  estado ENUM('PENDIENTE','CONFIRMADO','ANULADO') NOT NULL DEFAULT 'PENDIENTE',
  categoria_id BIGINT UNSIGNED NULL,
  cuenta_bancaria_id BIGINT UNSIGNED NULL,
  usuario_id BIGINT UNSIGNED NOT NULL,
  confirmado_por BIGINT UNSIGNED NULL,
  confirmado_en DATETIME NULL,
  motivo_anulacion VARCHAR(500) NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_mov_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  CONSTRAINT fk_mov_confirmador FOREIGN KEY (confirmado_por) REFERENCES usuarios(id),
  CONSTRAINT fk_mov_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id),
  CONSTRAINT fk_mov_cuenta FOREIGN KEY (cuenta_bancaria_id) REFERENCES cuentas_bancarias(id),
  CONSTRAINT chk_mov_monto CHECK (monto > 0),
  INDEX idx_mov_fecha_tipo (fecha,tipo),
  INDEX idx_mov_estado (estado)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comprobantes (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  movimiento_id BIGINT UNSIGNED NOT NULL,
  tipo_documento VARCHAR(60) NOT NULL,
  numero_documento VARCHAR(100) NOT NULL,
  fecha_documento DATE NOT NULL,
  archivo VARCHAR(255) NULL,
  observacion VARCHAR(500) NULL,
  usuario_id BIGINT UNSIGNED NOT NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_comp_mov FOREIGN KEY (movimiento_id) REFERENCES movimientos(id),
  CONSTRAINT fk_comp_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cierres_caja (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  fecha DATE NOT NULL,
  saldo_inicial DECIMAL(12,2) NOT NULL DEFAULT 0,
  total_ingresos DECIMAL(12,2) NOT NULL DEFAULT 0,
  total_egresos DECIMAL(12,2) NOT NULL DEFAULT 0,
  saldo_final DECIMAL(12,2) NOT NULL DEFAULT 0,
  observaciones VARCHAR(500) NULL,
  usuario_id BIGINT UNSIGNED NOT NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_cierre_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS auditoria (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id BIGINT UNSIGNED NULL,
  accion VARCHAR(80) NOT NULL,
  tabla_afectada VARCHAR(80) NOT NULL,
  registro_id BIGINT UNSIGNED NULL,
  detalle TEXT NULL,
  ip VARCHAR(45) NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_aud_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  INDEX idx_aud_fecha (creado_en)
) ENGINE=InnoDB;

INSERT IGNORE INTO categorias (nombre,tipo) VALUES
('Matrículas','INGRESO'),('Certificados','INGRESO'),('Otros ingresos','INGRESO'),
('Servicios','EGRESO'),('Materiales','EGRESO'),('Mantenimiento','EGRESO'),('Otros egresos','EGRESO');

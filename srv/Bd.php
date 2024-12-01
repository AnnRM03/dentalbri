<?php

require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_ROL.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/ROL_ID_ADMINISTRADOR.php";
require_once __DIR__ . "/ROL_ID_DENTISTA.php";

class Bd
{
    private static ?PDO $pdo = null;

    static function pdo(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                "sqlite:srvamuchos.db",
                null,
                null,
                [PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            // Crear tabla USUARIO
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS USUARIO (
                  USU_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                  USU_CUE TEXT NOT NULL,
                  USU_MATCH TEXT NOT NULL,
                  CONSTRAINT USU_CUE_UNQ UNIQUE(USU_CUE),
                  CONSTRAINT USU_CUE_NV CHECK(LENGTH(USU_CUE) > 0)
                )'
            );

            // Crear tabla ROL
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS ROL (
                  ROL_ID TEXT NOT NULL,
                  ROL_DESCRIPCION TEXT NOT NULL,
                  CONSTRAINT ROL_PK PRIMARY KEY(ROL_ID),
                  CONSTRAINT ROL_ID_NV CHECK(LENGTH(ROL_ID) > 0),
                  CONSTRAINT ROL_DESCR_UNQ UNIQUE(ROL_DESCRIPCION),
                  CONSTRAINT ROL_DESCR_NV CHECK(LENGTH(ROL_DESCRIPCION) > 0)
                )'
            );

            // Crear tabla USU_ROL
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS USU_ROL (
                   USU_ID INTEGER NOT NULL,
                   ROL_ID TEXT NOT NULL,
                   CONSTRAINT USU_ROL_PK PRIMARY KEY(USU_ID, ROL_ID),
                   CONSTRAINT USU_ROL_USU_FK FOREIGN KEY (USU_ID) REFERENCES USUARIO(USU_ID),
                   CONSTRAINT USU_ROL_ROL_FK FOREIGN KEY (ROL_ID) REFERENCES ROL(ROL_ID)
                )'
            );

            // Crear tabla ESPECIALIDAD
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS ESPECIALIDAD (
                    ESP_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                    ESP_NOMBRE TEXT NOT NULL UNIQUE,
                    CONSTRAINT ESP_NOMBRE_NV CHECK(LENGTH(ESP_NOMBRE) > 0)
                )'
            );

            // Crear tabla DENTISTA_ESPECIALIDAD
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS DENTISTA_ESPECIALIDAD (
                    DENTISTA_ID INTEGER NOT NULL,
                    ESP_ID INTEGER NOT NULL,
                    CONSTRAINT DEN_ESP_PK PRIMARY KEY (DENTISTA_ID, ESP_ID),
                    CONSTRAINT DEN_ESP_DEN_FK FOREIGN KEY (DENTISTA_ID) REFERENCES USUARIO (USU_ID),
                    CONSTRAINT DEN_ESP_ESP_FK FOREIGN KEY (ESP_ID) REFERENCES ESPECIALIDAD (ESP_ID)
                )'
            );

            // Crear tabla DENTISTA_DIAS
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS DENTISTA_DIAS (
                    DENTISTA_ID INTEGER NOT NULL,
                    DIA TEXT NOT NULL,
                    CONSTRAINT DEN_DIA_PK PRIMARY KEY (DENTISTA_ID, DIA),
                    CONSTRAINT DEN_DIA_DEN_FK FOREIGN KEY (DENTISTA_ID) REFERENCES USUARIO (USU_ID),
                    CONSTRAINT DIA_VALIDA CHECK (DIA IN ("Lunes", "Martes", "Miércoles", "Jueves", "Viernes"))
                )'
            );

            // Crear tabla SERVICIO
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS SERVICIO (
                    SERVICIO_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                    SERVICIO_NOMBRE TEXT NOT NULL,
                    SERVICIO_DESCRIPCION TEXT NOT NULL,
                    SERVICIO_PRECIO REAL NOT NULL,
                    SERVICIO_PROMOCION TEXT,
                    CONSTRAINT SERVICIO_NOMBRE_UNQ UNIQUE(SERVICIO_NOMBRE),
                    CONSTRAINT SERVICIO_NOMBRE_NV CHECK(LENGTH(SERVICIO_NOMBRE) > 0),
                    CONSTRAINT SERVICIO_DESCRIPCION_NV CHECK(LENGTH(SERVICIO_DESCRIPCION) > 0),
                    CONSTRAINT SERVICIO_PRECIO_NV CHECK(SERVICIO_PRECIO > 0)
                )'
            );

        }

        return self::$pdo;
    }
}

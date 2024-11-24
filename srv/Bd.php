<?php

require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_ROL.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/ROL_ID_ADMINISTRADOR.php";

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

            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS USUARIO (
                  USU_ID INTEGER,
                  USU_CUE TEXT NOT NULL,
                  USU_MATCH TEXT NOT NULL,
                  CONSTRAINT USU_PK PRIMARY KEY(USU_ID),
                  CONSTRAINT USU_CUE_UNQ UNIQUE(USU_CUE),
                  CONSTRAINT USU_CUE_NV CHECK(LENGTH(USU_CUE) > 0)
                )'
            );
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
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS USU_ROL (
                   USU_ID INTEGER NOT NULL,
                   ROL_ID TEXT NOT NULL,
                   CONSTRAINT USU_ROL_PK PRIMARY KEY(USU_ID, ROL_ID),
                   CONSTRAINT USU_ROL_USU_FK FOREIGN KEY (USU_ID) REFERENCES USUARIO(USU_ID),
                   CONSTRAINT USU_ROL_ROL_FK FOREIGN KEY (ROL_ID) REFERENCES ROL(ROL_ID)
                )'
            );
        }

        return self::$pdo;
    }
}

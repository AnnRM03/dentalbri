<?php

class Bd2
{
    private static ?PDO $pdo = null;

    static function pdo(): PDO
    {
        if (self::$pdo === null) {

            self::$pdo = new PDO(
                // cadena de conexión
                "sqlite:srvbd.db",
                // usuario
                null,
                // contraseña
                null,
                // Opciones: pdos no persistentes y lanza excepciones.
                [PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            self::$pdo->exec(
                "CREATE TABLE IF NOT EXISTS ADMINISTRADOR (
                    id_Administrador INTEGER,
                    nombre TEXT NOT NULL,
                    usuario TEXT NOT NULL,
                    correo TEXT NOT NULL,
                    contrasena TEXT NOT NULL,
                    CONSTRAINT ADMIN_PK PRIMARY KEY(id_Administrador),
                    CONSTRAINT ADMIN_CORREO_UNQ UNIQUE(correo),
                    CONSTRAINT ADMIN_USUARIO_UNQ UNIQUE(usuario),
                    CONSTRAINT ADMIN_NOM_NV CHECK(LENGTH(nombre) > 0)
                )"
            );
        }

        return self::$pdo;
    }
}

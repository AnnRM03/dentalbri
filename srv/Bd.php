<?php

require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/../lib/php/insert.php";
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
    // cadena de conexión
    "sqlite:srvaut.db",
    // usuario
    null,
    // contraseña
    null,
    // Opciones: pdos no persistentes y lanza excepciones.
    [PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
   );

   self::$pdo->exec(
    'CREATE TABLE IF NOT EXISTS USUARIO (
      USU_ID INTEGER,
      USU_CUE TEXT NOT NULL,
      USU_MATCH TEXT NOT NULL,
      CONSTRAINT USU_PK
       PRIMARY KEY(USU_ID),
      CONSTRAINT USU_CUE_UNQ
       UNIQUE(USU_CUE),
      CONSTRAINT USU_CUE_NV
       CHECK(LENGTH(USU_CUE) > 0)
     )'
   );
   self::$pdo->exec(
    'CREATE TABLE IF NOT EXISTS ROL (
      ROL_ID TEXT NOT NULL,
      ROL_DESCRIPCION TEXT NOT NULL,
      CONSTRAINT ROL_PK
       PRIMARY KEY(ROL_ID),
      CONSTRAINT ROL_ID_NV
       CHECK(LENGTH(ROL_ID) > 0),
      CONSTRAINT ROL_DESCR_UNQ
       UNIQUE(ROL_DESCRIPCION),
      CONSTRAINT ROL_DESCR_NV
       CHECK(LENGTH(ROL_DESCRIPCION) > 0)
     )'
   );
   self::$pdo->exec(
    'CREATE TABLE IF NOT EXISTS USU_ROL (
       USU_ID INTEGER NOT NULL,
       ROL_ID TEXT NOT NULL,
       CONSTRAINT USU_ROL_PK
        PRIMARY KEY(USU_ID, ROL_ID),
       CONSTRAINT USU_ROL_USU_FK
        FOREIGN KEY (USU_ID) REFERENCES USUARIO(USU_ID),
       CONSTRAINT USU_ROL_ROL_FK
        FOREIGN KEY (ROL_ID) REFERENCES ROL(ROL_ID)
      )'
   );

   if (selectFirst(
    pdo: self::$pdo,
    from: ROL,
    where: [ROL_ID => ROL_ID_ADMINISTRADOR]
   ) === false) {
    insert(
     pdo: self::$pdo,
     into: ROL,
     values: [
      ROL_ID => ROL_ID_ADMINISTRADOR,
      ROL_DESCRIPCION => "Administra el sistema."
     ]
    );
   }

   if (selectFirst(self::$pdo, ROL, [ROL_ID => ROL_ID_CLIENTE]) === false) {
    insert(
     pdo: self::$pdo,
     into: ROL,
     values: [
      ROL_ID => ROL_ID_CLIENTE,
      ROL_DESCRIPCION => "Realiza compras."
     ]
    );
   }
  }

  if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "Sara"]) === false) {
   insert(
    pdo: self::$pdo,
    into: USUARIO,
    values: [
     USU_CUE => "Sara",
     USU_MATCH => password_hash("123", PASSWORD_DEFAULT)
    ]
   );
   $usuId = self::$pdo->lastInsertId();
   insertBridges(
    pdo: self::$pdo,
    into: USU_ROL,
    valuesDePadre: [USU_ID => $usuId],
    valueDeHijos: [ROL_ID => [ROL_ID_CLIENTE]]
   );
  }

  if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "Ann"]) === false) {
   insert(
    pdo: self::$pdo,
    into: USUARIO,
    values: [
     USU_CUE => "Ann",
     USU_MATCH => password_hash("admin", PASSWORD_DEFAULT)
    ]
   );
   $usuId = self::$pdo->lastInsertId();
   insertBridges(
    pdo: self::$pdo,
    into: USU_ROL,
    valuesDePadre: [USU_ID => $usuId],
    valueDeHijos: [ROL_ID => [ROL_ID_ADMINISTRADOR]]
   );
  }

  if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "Erika"]) === false) {
   insert(
    pdo: self::$pdo,
    into: USUARIO,
    values: [
     USU_CUE => "Erika",
     USU_MATCH => password_hash("123", PASSWORD_DEFAULT)
    ]
   );
   $usuId = self::$pdo->lastInsertId();
   insertBridges(
    pdo: self::$pdo,
    into: USU_ROL,
    valuesDePadre: [USU_ID => $usuId],
    valueDeHijos: [ROL_ID => [ROL_ID_ADMINISTRADOR, ROL_ID_CLIENTE]]
   );
  }

  return self::$pdo;
 }
}

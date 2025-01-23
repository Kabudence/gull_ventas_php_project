<?php
require_once('db_credentials.php');

/**
 * Crea conexión a la base de datos
 */
function db_connect() {
  write_log("Intentando conectar a la base de datos...");
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

  if (!$connection) {
    write_log("Error al conectar: " . mysqli_connect_error());
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
  }

  write_log("Conexión exitosa a la base de datos.");
  return $connection;
}

/**
 * Cierra la conexión
 */
function db_disconnect($connection) {
  if (isset($connection)) {
    mysqli_close($connection);
    write_log("Conexión a la base de datos cerrada.");
  }
}

/**
 * Escapa cadenas
 */
function db_escape($connection, $string) {
  write_log("Escapando cadena para consulta SQL.");
  return mysqli_real_escape_string($connection, $string);
}

/**
 * Confirma conexión
 */
function confirm_db_connect() {
  if (mysqli_connect_errno()) {
    $msg = "Falló la conexión de la base de datos: ";
    $msg .= mysqli_connect_error();
    $msg .= " (" . mysqli_connect_errno() . ")";
    write_log($msg);
    exit($msg);
  }
}

/**
 * Confirma un result set
 */
function confirm_result_set($result_set) {
  if (!$result_set) {
    write_log("La consulta de la base de datos falló.");
    exit("La consulta de la base de datos falló.");
  }
}

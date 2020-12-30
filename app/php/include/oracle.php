<?php

function getOraclePDOObject() {

  $createTableQuery1 = "
    CREATE TABLE posts (
      id NUMBER(10) PRIMARY KEY,
      title VARCHAR2(255) NOT NULL
    )
  ";

  try {

    $server         = "oracle";
    $db_username    = "system";
    $db_password    = "oracle";
    $service_name   = "xe";
    $sid            = "xe";
    $port           = 1521;
    $dbtns          = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $server)(PORT = $port)) (CONNECT_DATA = (SERVICE_NAME = $service_name) (SID = $sid)))";

    $pdo = new PDO("oci:dbname=" . $dbtns . ";charset=utf8", $db_username, $db_password, array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));

  } catch (Exception $e) {
  }

  try {
    // $pdo->query("TRUNCATE TABLE posts;");
    // die;
    $pdo->query($createTableQuery1);
  } catch (Exception $e) {
  }

  return $pdo;
}

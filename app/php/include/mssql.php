<?php

function getMsSQLPDOObject() {
  // db
  try {
    $pdo = new PDO("sqlsrv:Server=mssql", "sa", getenv("SA_PASSWORD"));
    $pdo->exec("CREATE DATABASE dummy;");
  } catch (Exception $e) {}

  // table
  $createTableQuery = "
  IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='posts' and xtype='U')
    CREATE TABLE posts (
      id INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
      title VARCHAR(255) NOT NULL
    )
  ";

  $pdo = new PDO("sqlsrv:Server=mssql;Database=dummy", "sa", getenv("SA_PASSWORD"));
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->query($createTableQuery);
  return $pdo;
}

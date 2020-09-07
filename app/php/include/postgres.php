<?php

function getPGSQLPDOObject() {

  $createTableQuery = "
    CREATE TABLE IF NOT EXISTS posts (
      id SERIAL,
      title VARCHAR(255) NOT NULL,
      PRIMARY KEY(id)
    );
  ";

  $pdo = new PDO(vsprintf("pgsql:host=postgres;port=5432;dbname=%s;user=%s;password=%s", [
    getenv("POSTGRES_DB"),
    getenv("POSTGRES_USER"),
    getenv("POSTGRES_PASSWORD"),
  ]));
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->query($createTableQuery);
  return $pdo;
}

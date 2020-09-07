<?php

function getSQLitePDOObject() {

  $createTableQuery = "
    CREATE TABLE IF NOT EXISTS posts (
      id INTEGER PRIMARY KEY,
      title TEXT NOT NULL
    );
  ";

  $pdo = new PDO("sqlite:" . sys_get_temp_dir() . "/database.sql");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->query($createTableQuery);
  return $pdo;
}

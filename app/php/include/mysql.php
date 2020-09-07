<?php

function getMySQLPDOObject() {

  $createTableQuery = "
    CREATE TABLE IF NOT EXISTS `posts` (
      `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
      `title` VARCHAR(255) NOT NULL ,
      PRIMARY KEY (`id`)
    )
    ENGINE = InnoDB
    AUTO_INCREMENT = 1
    DEFAULT CHARACTER SET = utf8
    COLLATE = utf8_unicode_ci;
  ";

  $pdo = new PDO("mysql:host=mysql;dbname=" . getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->query($createTableQuery);
  return $pdo;
}

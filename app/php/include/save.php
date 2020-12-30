<?php

function insertInto($pdo, $title) {
  switch ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
    case 'mysql':
      $sql = vsprintf("INSERT INTO posts (id, title) VALUES (%d, '%s')", [
        time() - 1577836800,
        addslashes($title),
      ]);
      $stmt= $pdo->prepare($sql);
      $stmt->execute();
    break;
    case 'sqlite':
      $sql = vsprintf("INSERT INTO posts (id, title) VALUES (%d, '%s')", [
        time() - 1577836800,
        addslashes($title),
      ]);
      $stmt= $pdo->prepare($sql);
      $stmt->execute();
    break;
    case 'pgsql':
      $sql = vsprintf("INSERT INTO posts (id, title) VALUES (%d, '%s')", [
        time() - 1577836800,
        addslashes($title),
      ]);
      $stmt= $pdo->prepare($sql);
      $stmt->execute();
    break;
    case 'sqlsrv':
      $sql = vsprintf("INSERT INTO [dbo].[posts] ([id], [title]) VALUES (%d, '%s');", [
        time() - 1577836800,
        addslashes($title),
      ]);
      $stmt= $pdo->prepare($sql);
      $stmt->execute();
    break;
    case 'oci':
      $sql = vsprintf("INSERT INTO posts (id, title) VALUES (%d, '%s')", [
        time() - 1577836800,
        addslashes($title),
      ]);
      $stmt= $pdo->prepare($sql);
      $stmt->execute();
    break;
  }
}

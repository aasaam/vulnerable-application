<?php

function getOne($pdo, $id) {
  $result = [];
  switch ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
    case 'mysql':
      $stmt = $pdo->query("SELECT * FROM posts WHERE id = " . $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    break;
    case 'oci':
      $stmt = $pdo->query("SELECT * FROM posts WHERE id = " . $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    break;
    case 'sqlite':
      $stmt = $pdo->query("SELECT * FROM posts WHERE id = " . $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    break;
    case 'pgsql':
      $stmt = $pdo->query("SELECT * FROM posts WHERE id = " . $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    break;
    case 'sqlsrv':
      $stmt = $pdo->query("SELECT * FROM [dbo].[posts] WHERE [id] = " . $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    break;
  }

  return $result;
}

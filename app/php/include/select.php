<?php

function getList($pdo) {
  $result = [];
  switch ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
    case 'mysql':
      $stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 'sqlite':
      $stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 'pgsql':
      $stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 'sqlsrv':
      $stmt = $pdo->query("SELECT * FROM [dbo].[posts] ORDER BY [id] DESC");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    break;
  }

  return [
    'rows' => $result,
    'type' => $pdo->getAttribute(PDO::ATTR_DRIVER_NAME),
  ];
}

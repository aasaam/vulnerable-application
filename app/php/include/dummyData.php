<?php

function savedDummy($type) {
  $cacheFile = sys_get_temp_dir() . '/dummyData.' . $type . '.bin';
  if (file_exists(($cacheFile))) {
    return true;
  }
  file_put_contents($cacheFile, '1');
  return false;
}

function dummyData($pdos) {


    $data = [
      1 => 'DevOps is important',
      2 => 'Software engineering',
      3 => 'Distributions of Linux',
    ];

    foreach ($pdos as $pdo) {
      foreach ($data as $id => $title) {
        switch ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
          case 'mysql':
            try {
              if (savedDummy('mysql')) {
                break 2;
              }
              $sql = vsprintf("INSERT INTO posts (id, title) VALUES (%d, '%s')", [
                $id,
                addslashes($title),
              ]);
              $stmt= $pdo->prepare($sql);
              $stmt->execute();
            } catch (Exception $e) {
            }

          break;
          case 'sqlite':
            try {
              if (savedDummy('sqlite')) {
                break 2;
              }
              $sql = vsprintf("INSERT INTO posts (id, title) VALUES (%d, '%s')", [
                $id,
                addslashes($title),
              ]);
              $stmt= $pdo->prepare($sql);
              $stmt->execute();
            } catch (Exception $e) {
            }
          break;
          case 'pgsql':
            try {
              if (savedDummy('pgsql')) {
                break 2;
              }
              $sql = vsprintf("INSERT INTO posts (id, title) VALUES (%d, '%s')", [
                $id,
                addslashes($title),
              ]);
              $stmt= $pdo->prepare($sql);
              $stmt->execute();
            } catch (Exception $e) {
            }
          break;
          case 'sqlsrv':
            try {
              if (savedDummy('sqlsrv')) {
                break 2;
              }
              $sql = vsprintf("INSERT INTO [dbo].[posts] ([id], [title]) VALUES (%d, '%s');", [
                $id,
                addslashes($title),
              ]);
              $stmt= $pdo->prepare($sql);
              $stmt->execute();
            } catch (Exception $e) {
            }
          break;
          case 'oci':
            try {
              if (savedDummy('oci')) {
                break 2;
              }
              $sql = vsprintf("INSERT INTO posts (id, title) VALUES (%d, '%s')", [
                $id,
                addslashes($title),
              ]);
              $stmt= $pdo->prepare($sql);
              $stmt->execute();
            } catch (Exception $e) {
            }
          break;
        }
      }
    }

}

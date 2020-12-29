<?php

function dummyData($mysql) {
  $data = [
    1 => 'The Fellowship of the Ring is the first of three volumes of the epic novel The Lord of the Rings.',
    2 => 'The Matrix is a 1999 American science fiction action film written and directed by the Wachowskis.',
  ];

  foreach ($data as $id => $title) {
    $sql = vsprintf("INSERT IGNORE INTO posts (id, title) VALUES (%d, '%s')", [
      $id,
      addslashes($title),
    ]);
    $stmt= $mysql->prepare($sql);
    $stmt->execute();
  }
}

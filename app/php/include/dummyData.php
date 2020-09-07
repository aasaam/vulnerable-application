<?php

function dummyData($mysql) {
  $data = [
    1 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    2 => 'Nullam sem mi, fermentum et neque id, ullamcorper maximus enim.',
    3 => 'Aliquam eget leo faucibus, accumsan nunc id, interdum nisl.',
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

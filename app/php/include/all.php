<?php

define('APP_TITLE', 'Vulnerable application');

function goToHome() {
  header('Location: /');
  die;
}

require_once __DIR__ . '/States.php';
require_once __DIR__ . '/mysql.php';
require_once __DIR__ . '/postgres.php';
require_once __DIR__ . '/save.php';
require_once __DIR__ . '/sqlite.php';
require_once __DIR__ . '/select.php';
require_once __DIR__ . '/getOne.php';
require_once __DIR__ . '/directoryTraversal.php';
require_once __DIR__ . '/dummyData.php';

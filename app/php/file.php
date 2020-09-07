<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function showFile($path) {
  return file_get_contents(__DIR__ . '/files/' . $path);
}

header('Content-Type: text/plain');
echo showFile($_GET['f']);

<?php

function showFileList($path) {
  return array_diff(scandir($path), array('.', '..'));
}


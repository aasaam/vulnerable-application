<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once './include/all.php';

$mysql = getMySQLPDOObject();
$pgsql = getPGSQLPDOObject();
$sqlite = getSQLitePDOObject();
$mssql = getMsSQLPDOObject();
$oracle = getOraclePDOObject();

$postData = [];

$dbType = base64_decode($_GET['type']);

switch ($dbType) {
  case 'mysql':
    $postData = getOne($mysql, $_GET['id']);
    break;
  case 'sqlite':
    $postData = getOne($sqlite, $_GET['id']);
    break;
  case 'pgsql':
    $postData = getOne($pgsql, $_GET['id']);
    break;
  case 'sqlsrv':
    $postData = getOne($mssql, $_GET['id']);
    break;
  case 'oci':
    $postData = getOne($oracle, $_GET['id']);
    break;
  default:
    echo $_GET['type'];
    die;
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $_GET['title']; ?> | <?php echo States::get("title", APP_TITLE); ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/bulma.css">
  <style>
    .form {
      width: 100%;
    }
  </style>
</head>

<body class="py-3">
  <div class="container is-fluid">
    <div class="columns">
      <div class="column content">
        <h3>Identifier: <code><?php echo $_GET['id']; ?></code> from <code data-decode-me="<?php echo $_GET['type']; ?>">ENCODED</code></h3>
        <h1><?php echo $_GET['title']; ?></h1>
      </div>
    </div>
  </div>
  <script>
    window.setTimeout(function() {
      document.querySelectorAll('[data-decode-me]').forEach((e) => {
        e.innerHTML = window.atob(e.getAttribute('data-decode-me'));
      });
    }, 1000);
  </script>
</body>

</html>

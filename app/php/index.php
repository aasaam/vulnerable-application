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

dummyData([
  $mysql,
  $pgsql,
  $mssql,
  $sqlite,
  $oracle,
]);

if (isset($_POST['file-upload'])) {
  $file = $_FILES["sample-file"]["tmp_name"];
  header('Content-type: ' . $_FILES["sample-file"]['type']);
  readfile($file);
  die;
} else if (isset($_POST['type']) && !empty(trim($_POST['title']))) {

  $typeDb = base64_decode($_POST['type']);
  switch ($typeDb) {
    case 'mysql':
      insertInto($mysql, $_POST['title']);
      goToHome();
      break;
    case 'sqlite':
      insertInto($sqlite, $_POST['title']);
      goToHome();
      break;
    case 'pgsql':
      insertInto($pgsql, $_POST['title']);
      goToHome();
      break;
    case 'sqlsrv':
      insertInto($mssql, $_POST['title']);
      goToHome();
      break;
    case 'oci':
      insertInto($oracle, $_POST['title']);
      goToHome();
      break;
    default:
  }
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo States::get("title", APP_TITLE); ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/bulma.css">
  <style>
    body {
      padding: 8px;
    }
    .form {
      width: 100%;
    }

    #logo {
      max-width: 96px;
    }
  </style>
</head>

<body class="py-3">
  <div class="container is-fluid">
    <div class="columns">
      <div class="column">
        <section class="hero">
          <div class="hero-body">
            <div class="has-text-centered">
              <img id="logo" src="./logo.svg" alt="aasaam" />
            </div>
            <h1 class="title has-text-centered">
              <a href="/"><?php echo APP_TITLE; ?></a>
            </h1>
            <p class="has-text-centered">
              Test application for follow the SQL/XSS and other injection test cases.
            </p>
            <br />
<?php
if (isset($_SERVER['HTTP_X_AASAAM_IS_MODERN'])) :
?>
  <div class="notification is-success">
  <h3 class="has-text-centered">This application is <strong>PROTECTED</strong></h3>
  </div>
<?php else : ?>
  <div class="notification is-danger">
    <h3 class="has-text-centered">This application is <strong>NOT PROTECTED</strong></h3>
  </div>
</div>
<?php endif; ?>
          </div>
        </section>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <section class="hero">
          <div class="hero-body">
            <h1 class="title">
              File uploader
            </h1>
            <p>
              Try to upload files with extensions like<code>.php .exe .dll .so</code>
              <br />
              Normal files like images <code>.jpg .gif .png</code> is okey.
            </p>
            <br />
            <form class="form" action="" method="POST" enctype="multipart/form-data">
              <div class="field is-grouped">
                <div class="file has-name">
                  <label class="file-label">
                    <input class="file-input" type="file" name="sample-file">
                    <input type="hidden" name="file-upload" value="1">
                    <span class="file-cta">
                      <span class="file-icon">
                        <i class="fas fa-upload"></i>
                      </span>
                      <span class="file-label">
                        Choose a file…
                      </span>
                    </span>
                  </label>
                </div>
                <p class="control">
                  <input type="submit" class="button is-info" value="Upload">
                </p>
              </div>
            </form>
          </div>
        </section>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <section class="hero">
          <div class="hero-body">
            <h1 class="title">
              Directory/Path traversal
            </h1>
            <p>List of files you can test:</p>
            <?php $list = showFileList(__DIR__ . '/files'); ?>
            <ul>
              <?php foreach ($list as $file) : ?>
                <li>
                  📄
                  <a href="/file.php?f=<?php echo $file; ?>">
                    <?php echo $file; ?>
                  </a>
                </li>
                <li>
                  ⚠️
                  <a href="/file.php?f=../index.php">
                    How about see source code ?
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </section>
      </div>
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <section class="hero">
          <div class="hero-body">
            <h1 class="title">
              SQL Injections and XSS
            </h1>
          </div>
        </section>
      </div>
    </div>
    <div class="columns">
      <div class="column is-half">
        <article class="panel is-primary">
          <?php $result = getList($mssql); ?>
          <p class="panel-heading">
            MSSQL (<?php echo $mssql->getAttribute(PDO::ATTR_SERVER_VERSION)?>)
          </p>
          <div class="panel-block">
            <form class="form" action="" method="POST">
              <div class="field is-grouped">
                <p class="control is-expanded">
                  <input class="input" name="title" type="text" placeholder="Type new title here">
                  <input type="hidden" name="type" value="<?php echo $result['type']; ?>">
                </p>
                <p class="control">
                  <input type="submit" class="button is-info" value="Save">
                </p>
              </div>
            </form>
          </div>
          <div class="panel-block">
            <table class="table is-fullwidth">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Test</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($result['rows'] as $row) :
                ?>
                  <tr>
                    <td>

                      <?php echo $row['id']; ?>

                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['id']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['title']); ?>">
                        <?php echo $row['title']; ?>
                      </a>
                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['id']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['title'] . '<script>alert("xss");</script>'); ?>">
                        ⚠️
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </article>
      </div>
      <div class="column is-half">
        <article class="panel is-primary">
          <?php $result = getList($mysql); ?>
          <p class="panel-heading">
            MySQL (<?php echo $mysql->getAttribute(PDO::ATTR_SERVER_VERSION)?>)
          </p>
          <div class="panel-block">
            <form class="form" action="" method="POST">
              <div class="field is-grouped">
                <p class="control is-expanded">
                  <input class="input" name="title" type="text" placeholder="Type new title here">
                  <input type="hidden" name="type" value="<?php echo $result['type']; ?>">
                </p>
                <p class="control">
                  <input type="submit" class="button is-info" value="Save">
                </p>
              </div>
            </form>
          </div>
          <div class="panel-block">
            <table class="table is-fullwidth">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Test</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($result['rows'] as $row) :
                ?>
                  <tr>
                    <td>

                      <?php echo $row['id']; ?>

                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['id']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['title']); ?>">
                        <?php echo $row['title']; ?>
                      </a>
                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['id']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['title'] . '<script>alert("xss");</script>'); ?>">
                        ⚠️
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </article>
      </div>
    </div>
    <div class="columns">
      <div class="column is-half">
        <article class="panel is-primary">
          <?php $result = getList($oracle); ?>
          <p class="panel-heading">
            Oracle (<?php echo $oracle->getAttribute(PDO::ATTR_SERVER_VERSION)?>)
          </p>
          <div class="panel-block">
            <form class="form" action="" method="POST">
              <div class="field is-grouped">
                <p class="control is-expanded">
                  <input class="input" name="title" type="text" placeholder="Type new title here">
                  <input type="hidden" name="type" value="<?php echo $result['type']; ?>">
                </p>
                <p class="control">
                  <input type="submit" class="button is-info" value="Save">
                </p>
              </div>
            </form>
          </div>
          <div class="panel-block">
            <table class="table is-fullwidth">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Test</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($result['rows'] as $row) :
                ?>
                  <tr>
                    <td>

                      <?php echo $row['ID']; ?>

                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['ID']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['TITLE']); ?>">
                        <?php echo $row['TITLE']; ?>
                      </a>
                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['ID']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['TITLE'] . '<script>alert("xss");</script>'); ?>">
                        ⚠️
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </article>
      </div>
      <div class="column is-half">
        <article class="panel is-primary">
          <?php $result = getList($pgsql); ?>
          <p class="panel-heading">
            Postgres (<?php echo $pgsql->getAttribute(PDO::ATTR_SERVER_VERSION)?>)
          </p>
          <div class="panel-block">
            <form class="form" action="" method="POST">
              <div class="field is-grouped">
                <p class="control is-expanded">
                  <input class="input" name="title" type="text" placeholder="Type new title here">
                  <input type="hidden" name="type" value="<?php echo $result['type']; ?>">
                </p>
                <p class="control">
                  <input type="submit" class="button is-info" value="Save">
                </p>
              </div>
            </form>
          </div>
          <div class="panel-block">
            <table class="table is-fullwidth">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Test</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($result['rows'] as $row) :
                ?>
                  <tr>
                    <td>

                      <?php echo $row['id']; ?>

                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['id']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['title']); ?>">
                        <?php echo $row['title']; ?>
                      </a>
                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['id']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['title'] . '<script>alert("xss");</script>'); ?>">
                        ⚠️
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </article>
      </div>
    </div>
    <div class="columns">
      <div class="column is-half">
        <article class="panel is-primary">
          <?php $result = getList($sqlite); ?>
          <p class="panel-heading">
            SQLite (<?php echo $sqlite->getAttribute(PDO::ATTR_SERVER_VERSION)?>)
          </p>
          <div class="panel-block">
            <form class="form" action="" method="POST">
              <div class="field is-grouped">
                <p class="control is-expanded">
                  <input class="input" name="title" type="text" placeholder="Type new title here">
                  <input type="hidden" name="type" value="<?php echo $result['type']; ?>">
                </p>
                <p class="control">
                  <input type="submit" class="button is-info" value="Save">
                </p>
              </div>
            </form>
          </div>
          <div class="panel-block">
            <table class="table is-fullwidth">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Test</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($result['rows'] as $row) :
                ?>
                  <tr>
                    <td>

                      <?php echo $row['id']; ?>

                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['id']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['title']); ?>">
                        <?php echo $row['title']; ?>
                      </a>
                    </td>
                    <td>
                      <a href="/show.php?id=<?php echo $row['id']; ?>&type=<?php echo $result['type']; ?>&title=<?php echo urlencode($row['title'] . '<script>alert("xss");</script>'); ?>">
                        ⚠️
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </article>
      </div>
    </div>
  </div>
</body>

</html>

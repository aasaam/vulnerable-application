<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once './include/all.php';

$mysql = getMySQLPDOObject();
$pgsql = getPGSQLPDOObject();
$sqlite = getSQLitePDOObject();

dummyData($mysql);

if (isset($_POST['file-upload'])) {
  $file = $_FILES["sample-file"]["tmp_name"];
  header('Content-type: ' . $_FILES["sample-file"]['type']);
  readfile($file);
  die;
} else if (isset($_POST['type']) && !empty(trim($_POST['title']))) {

  switch ($_POST['type']) {
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
          </div>
        </section>
      </div>
    </div>
    <div class="columns">
      <div class="column">
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
    </div>
    <hr>
    <div class="columns">
      <div class="column">
        <section class="hero">
          <div class="hero-body">
            <h1 class="title">
              Directory/Path traversal
            </h1>
          </div>
        </section>
      </div>
    </div>
    <div class="columns">
      <div class="column is-12">
        <p>List of files you can test:</p>
      </div>
    </div>
    <div class="columns">

      <div class="column is-one-third">
        <?php $list = showFileList(__DIR__ . '/files'); ?>
        <ul>
          <?php foreach ($list as $file) : ?>
            <li>
              <a href="/file.php?f=<?php echo $file; ?>">
                <?php echo $file; ?>
              </a>
            </li>
            <li>
              <a href="/file.php?f=../index.php">
                🚫 How about see source code ?
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
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
      <div class="column">
        <article class="panel is-primary">
          <?php $result = getList($mysql); ?>
          <p class="panel-heading">
            MySQL
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
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </article>
      </div>
      <div class="column">
        <article class="panel is-primary">
          <?php $result = getList($sqlite); ?>
          <p class="panel-heading">
            SQLite
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
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </article>
      </div>
      <div class="column">
        <article class="panel is-primary">
          <?php $result = getList($pgsql); ?>
          <p class="panel-heading">
            Postgres
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

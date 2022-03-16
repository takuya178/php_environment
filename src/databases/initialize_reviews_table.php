<?php
require __DIR__ . '/../vendor/autoload.php';

function dbConnect() {
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
  $dotenv->load();

  $dbHost = $_ENV['DB_HOST'];
  $dbUserName = $_ENV['DB_USERNAME'];
  $dbPassword = $_ENV['DB_PASSWORD'];
  $dbDatabase = $_ENV['DB_DATABASE'];

  $link = mysqli_connect($dbHost, $dbUserName, $dbPassword, $dbDatabase);

  // 例外処理
  if (!$link) {
    echo 'データベースに接続できませんでした' . PHP_EOL;
    echo 'Debugging error' . mysqli_connect_error() . PHP_EOL;
    exit;
  }

  return $link;
}

// 同じテーブルが存在する場合削除
function dropTableSql($link) {
  $sql = 'DROP TABLE IF EXISTS reviews;';
  $result = mysqli_query($link, $sql);

  if ($result) {
    echo 'テーブルを削除しました' . PHP_EOL; 
  } else {
    echo 'テーブルの削除に失敗しました' . PHP_EOL;
    echo 'Debugging Error' . mysqli_error($link) . PHP_EOL;
  }
}

// テーブルの新規作成
function createTableSql($link) {
  $sql = <<<EOL
  CREATE TABLE reviews (
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY kEY,
    title VARCHAR(255),
    author VARCHAR(255),
    status VARCHAR(5),
    score INTEGER,
    summary VARCHAR(255),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) DEFAULT CHARACTER SET=utf8mb4;
  EOL;
  $result = mysqli_query($link, $sql);

  if ($result) {
    echo 'テーブルを作成しました' . PHP_EOL;
  } else {
    echo 'テーブルの作成に失敗しました' . PHP_EOL;
    echo 'Debugging Error' . mysqli_error($link) . PHP_EOL;
  }
}

$link = dbConnect();
dropTableSql($link);
createTableSql($link);
mysqli_close($link);
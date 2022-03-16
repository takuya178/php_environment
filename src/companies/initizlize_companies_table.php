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
    echo 'ERROR: データベースに接続できませんでした' . PHP_EOL;
    echo 'Debugging error' . mysqli_connect_error() . PHP_EOL;
    exit;
  }

  return $link;
}

function dropTable($link) {
  $dropTableSql = 'DROP TABLE IF EXISTS companies;';
  $result = mysqli_query($link, $dropTableSql);

  if ($result) {
    echo 'テーブルを削除しました' . PHP_EOL;
  } else {
    echo 'テーブルの削除に失敗しました' . PHP_EOL;
    echo 'Debugging Error;' . mysqli_error($link) . PHP_EOL; 
  }
}

function createTable($link) {
  $createTableSql = <<<EOT
  CREATE TABLE companies (
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    establish_date DATE,
    founder VARCHAR(255),
    create_at TIMESTAMP NOT NULL DEFAULT  CURRENT_TIMESTAMP
  ) DEFAULT CHARACTER SET=utf8mb4;
  EOT;  
  $result = mysqli_query($link, $createTableSql);

  if ($result) {
    echo 'テーブルを作成しました' . PHP_EOL;
  } else {
    echo 'テーブルの作成に失敗しました' . PHP_EOL;
    echo 'Debugging Error;' . mysqli_error($link) . PHP_EOL; 
  }
}

$link = dbConnect();
dropTable($link);
createTable($link);
mysqli_close($link);

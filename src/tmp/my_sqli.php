<?php
$link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

// 例外処理
if (!$link) {
  echo 'ERROR: データベースに接続できませんでした' . PHP_EOL;
  echo 'Debugging error' . mysqli_connect_error() . PHP_EOL;
  exit;
}

$sql = 'SELECT name, founder FROM companies';
$results = mysqli_query($link, $sql);

while ($company = mysqli_fetch_assoc($results)) {
  echo '会社名:' . $company['name'] . PHP_EOL;
  echo '代表者名:' . $company['founder '] . PHP_EOL;
}

mysqli_free_result($results);

// echo 'データベースに接続できました' . PHP_EOL; 

// $sql = <<<EOT
// INSERT INTO companies (
//   name,
//   establish_date,
//   founder
// ) VALUES (
//   'SmartHR',
//   '2022-02-15',
//   'ura'
// )
// EOT;
// $result = mysqli_query($link, $sql);

// if ($result) {
//   echo 'データが保存されました' . PHP_EOL;
// } else {
//   echo 'データの追加に失敗しました' . PHP_EOL;
//   echo 'Debugging Error:' .mysqli_error($link) . PHP_EOL;
// }

mysqli_close($link);
echo 'データベースを切断しました' . PHP_EOL;
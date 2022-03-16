<?php

$title = '';
$author = '';
$status = '';
$score = '';
$summary = '';


function validate($reviews) {
  $errors = [];
  // 書籍名のバリデーション
  if (!strlen($reviews['title'])) {
    $errors['title'] = '書籍名を入力してください';
  } elseif ($reviews['title'] > 100) {
    $errors['title'] = '書籍名は100文字以内で入力してください';
  }

  // 評価のバリデーション
  if (!is_int($reviews['score'])) {
    $errors['score'] = '入力値は整数で入力してください'; 
  } elseif ($reviews['score'] < 1 || $reviews['score'] > 5 ) {
    $errors['score'] = '数値は1以上5以下の値を入力してください';
  }

  // 著者名のバリデーション
  if (!$reviews['author']) {
    $errors['author'] = '著者名を入力してください';
  } elseif ($reviews['author'] > 100) {
    $errors['author'] = '著者名は100文字以内で入力してください';
  }

  // 読書状況のバリデーション
  // if (!in_array('未読', $reviews) || !in_array('読んでる', $reviews) || !in_array('読了', $reviews))
  if (!in_array($reviews['status'], ['未読', '読んでる', '読了'], true)) {
    $errors['status'] = '読書状況には、「未読」、「読んでる」、「読了」のいずれかを入力してください';
  }

  // 感想に関するバリデーション
  if (!$reviews['summary']) {
    $errors['summary'] = '感想を入力してください';
  }

  return $errors;
}



// 読書ログを登録する処理
function createReview($link) {
  $reviews = [];

  echo '読書ログを登録してください' . PHP_EOL;
  echo '書籍名：';
  $reviews['title'] = trim(fgets(STDIN));
  
  echo '著者名：';
  $reviews['author'] = trim(fgets(STDIN));
  
  echo '読書状況(未読、読んでいる、読了)：';
  $reviews['status'] = trim(fgets(STDIN));
  
  echo '評価(5点満点)：';
  $reviews['score'] = (int) trim(fgets(STDIN));
  
  echo '感想：';
  $reviews['summary'] = trim(fgets(STDIN));
  
  $validated = validate($reviews);
  if(count($validated) > 0) {
    foreach($validated as $error) {
      echo $error . PHP_EOL;
    }
    return;
  }

  $sql = <<<EOT
  INSERT INTO reviews(
    title,
    author,
    status,
    score,
    summary
  ) VALUES (
    "{$reviews['title']}",    
    "{$reviews['author']}",    
    "{$reviews['status']}",    
    "{$reviews['score']}",    
    "{$reviews['summary']}"
  )
  EOT;

  $result = mysqli_query($link, $sql);

  if ($result) {
    echo 'データを保存しました' . PHP_EOL;
  } else {
    echo 'データの保存に失敗しました' . PHP_EOL;
    echo 'Debugging Error;' . mysqli_error($link) . PHP_EOL; 
  }

  // $reviews[]とすることで、reviewsの配列に代入することができる。
    return [
      'title' => $reviews['title'],
      'author' => $reviews['author'],
      'status' => $reviews['status'],
      'score' => $reviews['score'],
      'summary' => $reviews['summary']
    ];
}

// 読書ログの表示機能
function displayReview($link) {
  echo '読書ログを表示します' . PHP_EOL;

  $sql = 'SELECT * FROM reviews';
  
  $result = mysqli_query($link, $sql);
  while($reviews = mysqli_fetch_assoc($result)) {
    echo '書籍名:' . $reviews['title'] . PHP_EOL;
    echo '著者名:' . $reviews['author'] . PHP_EOL;
    echo '読書状況:' . $reviews['status'] . PHP_EOL;
    echo '評価:' . $reviews['score'] . PHP_EOL;
    echo '感想:' . $reviews['summary'] . PHP_EOL;
    echo '----------------------' . PHP_EOL;
  }
  mysqli_free_result($result);
}


// MySQLへ接続する機能
function dbConnect() {
  $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

  // 例外処理
  if (!$link) {
    echo 'データベースに接続できませんでした' . PHP_EOL;
    echo 'Debugging error' . mysqli_connect_error() . PHP_EOL;
    exit;
  }
  
  // $link は mysqli_connect() の戻り値である、データベースとの接続情報
  // データベースと切断したり、テーブルからデータを取得・登録する際に接続情報を使用するので、return で返す
  return $link;
}

$reviews = [];

$link = dbConnect();

while(true) {
  echo '1.読書ログを登録' . PHP_EOL;
  echo '2.読書ログを表示' . PHP_EOL;
  echo '9.アプリケーションを終了' . PHP_EOL;
  echo '番号を入力してください（1,2,9）：';
  $num = trim(fgets(STDIN));
  
  if ($num === '1') {
    $reviews[] = createReview($link);

  } elseif ($num === '2') {
    displayReview($link);

  } elseif ($num === '9') {
    mysqli_close($link);
    break;
  }
}

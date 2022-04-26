<?php

require_once __DIR__ . '/lib/mysqli2.php';

function createReviews($link, $review)
{
  $sql = <<<EOT
INSERT INTO reviews (
  title,
  author,
  status,
  score,
  summary
) VALUES (
  "{$review['title']}",
  "{$review['author']}",
  "{$review['status']}",
  "{$review['score']}",
  "{$review['summary']}"
)
EOT;

  $result = mysqli_query($link, $sql);
  if (!$result) {
    error_log('Error: fail to create reviews');
    error_log('Debugging Error:' . mysqli_error($link));
  }
}

function validate($review)
{
  $errors = [];

  //書籍名
  if (!strlen($review['title'])) {
    $errors['title'] = '書籍名を入力してください。';
  } elseif (strlen($review['title']) > 255) {
    $errors['title'] = '書籍名は255文字以内で入力してください。';
  }
  //著者名
  if (!strlen($review['author'])) {
    $errors['author'] = '著者名を入力してください。';
  } elseif (strlen($review['author'] > 255)) {
    $errors['author'] = '著者名は255文字以内で入力してください。';
  }
  //読書状況
  if (!in_array($review['status'], ['未読', '読んでる', '読了'])) {
    $errors['status'] = '読書状況は「未読」「読んでる」「読了」のいずれかを選択してください。';
  }
  //評価
  if ($review['score'] > 5 || $review['score'] < 1) {
    $errors['score'] = '評価は１〜５の整数を入力してください。';
  }
  if ($review['summary'] > 255) {
    $errors['summary'] = '感想は255文字以内で入力してください。';
  } elseif (!$review['summary']) {
    $errors['summary'] = '感想を入力してください。';
  }

  return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $status = '';
  if (array_key_exists('status', $_POST)) {
    $status = $_POST['status'];
  }
  $review = [
    'title' => $_POST['title'],
    'author' => $_POST['author'],
    'status' => $status,
    'score' => $_POST['score'],
    'summary' => $_POST['summary'],
  ];

  //バリデーションする
  $errors = validate($review);
  if (!count($errors)) {
    $link = dbConnect();
    createReviews($link, $review);
    mysqli_close($link);
    header("Location: index2.php");
  }
}
$title = '読書ログを登録';
$content = __DIR__ . '/./views/new2.php';
include __DIR__ . '/./views/layout2.php';

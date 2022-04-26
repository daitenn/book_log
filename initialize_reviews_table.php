<?php

require_once __DIR__ . '/lib/mysqli2.php';

function dropTable($link)
{
  $dropTableSql = 'DROP TABLE IF EXISTS reviews;';
  $result = mysqli_query($link, $dropTableSql);
  if ($result) {
    echo 'テーブルを削除いたしました。' . PHP_EOL;
  } else {
    echo 'テーブルの削除ができませんでした。' . PHP_EOL;
    echo 'Debugging error:' . mysqli_error($link) . PHP_EOL;
  }
}

function createTable($link)
{
  $createTableSql = <<<EOT
  CREATE TABLE reviews (
  id INTEGER AUTO_INCREMENT NOT NULL  PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(100),
  status VARCHAR(10),
  score INTEGER,
  summary VARCHAR(1000),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARACTER SET=utf8mb4;
EOT;

  $result = mysqli_query($link, $createTableSql);
  if ($result) {
    echo 'テーブルを作成いたしました。' . PHP_EOL;
  } else {
    echo 'テーブルの作成に失敗いたしました。' . PHP_EOL;
    echo 'Debugging error:' . mysqli_error($link) . PHP_EOL;
  }
}

$link = dbConnect();
dropTable($link);
createTable($link);
mysqli_close($link);

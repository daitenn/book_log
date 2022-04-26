<?php

$errors = [];

$review = [
  'title' => '',
  'author' => '',
  'status' => '未読',
  'score' => '',
  'summary' => ''
];

$title = '読書ログを登録';
$content = __DIR__ . "/./views/new2.php";
include __DIR__ . '/./views/layout2.php';

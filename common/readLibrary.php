<?php

require_once(__DIR__ . '/../vendor/autoload.php');

//クラスの読み込み
use Dotenv\Dotenv;

// .envから環境変数を読み込むための処理
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
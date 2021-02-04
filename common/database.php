<?php
/**
 * PDOを使用してデーターベースに接続する
 * @return PDO
 */

 require_once('readLibrary.php');

 function getDatabaseConnection(){
     try {
        $dbh = new PDO(
            $_ENV['DB_DSN'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            [
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
            ]
        );       
     } catch (Exception $e) {
        echo "データベースの接続に失敗しました。";
        echo $e->getMessage();
        exit;
     }
     return $dbh;
 }
<?php
session_start();

require_once __DIR__ . "/../../common/validation.php";
require_once __DIR__ . "/../../common/database.php";

// フォームから受け取ったデータ
$user_name = $_POST['user_name'];
$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];

// 空チェック
emptyCheck($user_name, "ユーザー名を入力してください。");
emptyCheck($user_email, "メールアドレスを入力してください。");
emptyCheck($user_password, "パスワードを入力してください。");

// 文字数チェック
stringMaxSizeCheck($user_name, "ユーザー名は255文字以内で入力してください。");
stringMaxSizeCheck($user_email, "メールアドレスは255文字以内で入力してください。");
stringMaxSizeCheck($user_password, "パスワードは255文字以内に入力してください。");
stringMinSizeCheck($user_password, "パスワードは8文字以上で入力してください。");

if(!$_SESSION['errors']){
    emailCheck($user_email,"正しいメールアドレスを入力してください。");

    halfAlphanumericCheck($user_name,"ユーザー名は半角英数字で入力してください。");
    halfAlphanumericCheck($user_password,"ユーザー名は半角英数字で入力してください。");

    emailDuplicationCheck($user_email,"既に登録されているメールアドレスです。");
}

if($_SESSION['errors']){
    header('Location: __DIR__ . /../../../user/');
    exit;
}

// データベースの接続
$dbh = getDatabaseConnection();

try {
    $password = password_hash($user_password, PASSWORD_DEFAULT);

    $sql = "insert into users(name, email, password) values(:name,:email,:password)";
    $prepare = $dbh->prepare($sql);

    $prepare->bindValue(':name', htmlspecialchars($user_name));
    $prepare->bindValue(':email', $user_email);
    $prepare->bindValue(':password', $password);

    $prepare->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

header('Location: __DIR__ . /../../memo');
exit;


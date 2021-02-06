<?php
session_start();

require_once __DIR__ . '/../../common/database.php';
require_once __DIR__ . '/../../common/validation.php';

// フォームから受け取ったデータ
$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];

// 空チェック
emptyCheck($user_email, 'メールアドレスを入力してください。');
emptyCheck($user_password, 'パスワードを入力してください。');

// 文字数チェック
stringMaxSizeCheck($user_email, 'メールアドレスは255文字以内で入力してください。');
stringMaxSizeCheck($user_password, 'パスワードは255文字以内で入力してください。');
stringMinSizeCheck($user_email, 'パスワードは8文字以上で入力してください。');

if (!$_SESSION['errors']) {
    emailCheck($user_email, '正しいメールアドレスを入力してください。');
    halfAlphanumericCheck($user_email, 'パスワードは半角英数字で入力してください。');
}

if ($_SESSION['errors']) {
    header('Location: __DIR__ . /../../../login/index.php');
    exit;
}

try {
    $dbh = getDatabaseConnection();
    $sql = "select id,name,password from users where email = :user_email";
    $prepare = $dbh->prepare($sql);
    
    $prepare->bindValue(':user_email', $user_email);
    $prepare->execute();
    $user = $prepare->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {        
        $_SESSION['errors'] = 'メールアドレスまたはパスワードが間違っています。';       
        header('Location: __DIR__ . /../../../login/index.php');
        exit;
    }
    
    $name = $user['name'];
    $id  = $user['id'];
    
    if (password_verify($user_password, $user['password'])) {
        $_SESSION['user'] = [
            'name' => $name,
            'id' => $id,
        ];
        header('Location: __DIR__ . /../../../memo');
    } else {
        $_SESSION['errors'] = 'メールアドレスまたはパスワードが間違っています。';        
        header('Location: __DIR__ . /../../../login');
        exit;
    }
} catch (Exception $e) {
    $e->getMessage();
    exit;
}

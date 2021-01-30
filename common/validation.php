<?php
$_SESSION['errors'] = array();

/**
 * 空チェック
 * @parm $
 * @$check_value
 * @$message
 */

function emptyCheck($check_value, $message)
{
    if (empty(trim($check_value))) {
        array_push($_SESSION['errors'], $message);       
    }
}

/**
 * 最小文字のチェック
 * @parm $
 * @$check_value
 * @$message
 * @int $min_size
 */

function stringMinSizeCheck($check_value, $message, $min_size = 8)
{
    if (mb_strlen($check_value) < $min_size) {
        array_push($_SESSION['errors'], $message);   
    }
}

/**
 * 最大文字数のチェック
 * @parm $
 * @$check_value
 * @$message
 * @int $max_size
 */
function stringMaxSizeCheck($check_value, $message, $max_size = 255)
{
    if (mb_strlen($check_value) > $max_size) {
        array_push($_SESSION['errors'], $message);
    }
}

/**
 * メールアドレスのチェック
 * @parm $
 * @$check_value
 * @$message
 */

function emailCheck($check_value, $message)
{
    if (filter_var($check_value, FILTER_VALIDATE_EMAIL) === false) {
        array_push($_SESSION['errors'], $message);
    }
}

/**
 * 半角英数字のチェック
 * @parm $
 * @$check_value
 * @$message
 */

function halfAlphanumericCheck( $check_value, $message)
{
    if (preg_match("/^[a-zA-Z0-9]+$/", $check_value) === false) {
        array_push($_SESSION['errors'], $message);
    }
}


/**
 * メールアドレスの重複チェック
 * @parm $
 * @$check_value
 * @$message
 */

function emailDuplicationCheck($check_value, $message)
{
    try {
        $dbh = getDatabaseConnection();
        $sql = 'select id from users where email = :user_email';
        $prepare = $dbh->prepare($sql);
        if ($prepare) {
            $prepare->bindValue(':user_email', $check_value);
            $prepare->execute();
        }

        $result = $prepare->fetch(PDO::FETCH_ASSOC);

        if($result){
            array_push($_SESSION['errors'], $message);
        }
    } catch (Exception $e) {
        echo $e->getMessage('障害が発生しております。');
        exit;
    }
}

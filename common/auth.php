<?php

if (!isset($_SESSION)) {
    session_start();
}

/**
 * ログインしているかチェックする
 * @return bool
 */

function isLogin()
{
    if (isset($_SESSION['user'])) {
        return true;
    }

    return false;
}

/**
 * ログインしているユーザー名を取得
 * @return string
 */
function getLoginUserName()
{
    if (isset($_SESSION['user'])) {
        $name = $_SESSION['user']['name'];

        if (mb_strlen($name) > 7) {
            $name = mb_substr($name, 0, 7) . '...';
        }

        return $name;
    }

    return "";
}

/**
 * ログインしているユーザーのIDを取得
 * @return int
 */

function getLoginUserId()
{
    if (isset($_SESSION['user'])) {
        return $_SESSION['user']['id'];
    }

    return null;
}

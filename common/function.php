<?php

function loginCheck()
{
    if (isLogin()) {
        header('Location: ../memo');
        exit();
    }
    return false;
}

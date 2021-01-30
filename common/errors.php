<?php

function getErrors($errors)
{
    if (isset($errors)) {
        echo '<div class="alert alert-danger">';
        foreach ($errors as $err) {
            echo "<div>{$err}</div>";
        }
        echo '</div>';
    }
}

<?php

function getErrors($errors)
{
    if (isset($errors)) {
        echo '<div class="alert alert-danger">';

        if (is_array($errors)) {
            foreach ($errors as $err) {
                echo "<div>{$err}</div>";
            }
        } else {
            echo "<div>{$errors}</div>";
        }
        echo '</div>';
    }
}

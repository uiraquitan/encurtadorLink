<?php

include "config.php";

if (isset($_GET['del'])) {

    $del = mysqli_real_escape_string($conn, $_GET['del']);

    $delete = mysqli_query($conn, "DELETE FROM url WHERE shorten_ul = '{$del}'");

    if ($delete) {
        header('Location: ../');
    } else {
        header('Location: ../');
    }
} elseif (isset($_GET['delete'])) {

    $delete = mysqli_query($conn, "DELETE FROM url");

    if ($delete) {
        header('Location: ../');
    } else {
        header('Location: ../');
    }
} else {
    header('Location: ../');
}

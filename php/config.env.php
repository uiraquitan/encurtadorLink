<?php

$conn  = mysqli_connect("localhost", "root", "pass", "<BDNAME>");

//if database is connect whithout any erro
if (!$conn) {
    echo "Database Connection error " . mysqli_connect_error();
}

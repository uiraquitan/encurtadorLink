<?php
include "config.php";

$og_url = mysqli_real_escape_string($conn, $_POST['shorten_ul']);
$full_url = str_replace(" ", "", $og_url); // removing spaces from url if user  entered it
$hidden_url = mysqli_real_escape_string($conn, $_POST['hidden_url']);

if (!empty($full_url)) {
    // $domain = "localhost";
    //let's check user have edited or remove domain name or not
    if (preg_match("/\//i", $full_url)) {
        $explodeURL = explode("/", $full_url);
        $short_url = end($explodeURL);
        if ($short_url != "") {
            $sql = mysqli_query($conn, "SELECT shorten_ul FROM url WHERE shorten_ul = '{$short_url}' && shorten_ul != '{$hidden_url}'");
            if (mysqli_num_rows($sql) == 0) {
                //let's update the link or url
                $sql2 = mysqli_query($conn, "UPDATE url SET shorten_ul = '{$short_url}' WHERE shorten_ul = '{$hidden_url}'");
                if ($sql2) {
                    echo "success";
                } else {
                    echo "Something went wrong";
                }
            } else {
                echo "Error - This url already exist!";
            }
        } else {

            echo "Error - You have to enter shot URL!";
        }
    } else {

        echo "Inválid URL - You can't edit domain name!";
    }
} else {
    echo "Error - You have to enter shot URL!";
}

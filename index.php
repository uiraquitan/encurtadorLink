<!-- Redirect user to thier original link  using shorten link -->
<?php
include "php/config.php";

if (isset($_GET)) {
    // var_dump($_GET);

    $new_url = '';
    foreach ($_GET as $key => $value) {
        $u = mysqli_real_escape_string($conn, $key);
        $new_url = str_replace('/', '', $u);
    }


    // Gatting the full url og that shor url  which we are getting from url
    $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_ul = '{$new_url}'");

    if (mysqli_num_rows($sql) > 0) {

        $count_query = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_ul = '{$new_url}'");

        if ($count_query) {

            //let's redirect user
            $full_url = mysqli_fetch_assoc($sql);
            header("Location:" . $full_url['full_url']);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="wrapper">
        <form action="#">
            <i class="url-icon uil uil-link"></i>
            <input type="text" name="full-url" placeholder="Enter or paste a long url">
            <button>Shorten</button>
        </form>

        <?php
        // var_dump($_SERVER);
        $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC LIMIT 5");
        if (mysqli_num_rows($sql2) > 0) {
        ?>


            <div class="statistics">
                <?php

                $sql3 = mysqli_query($conn, "SELECT count(*) FROM url");

                $res = mysqli_fetch_assoc($sql3);

                $sql4 = mysqli_query($conn, "SELECT clicks FROM url");

                $total = 0;

                while ($c = mysqli_fetch_assoc($sql4)) {
                    $total = $c['clicks'] + $total;
                }

                ?>
                <span> Total Links: <span><?= end($res) ?></span> <span> & Total Clicks: <?= $total ?></span></span>
                <a href="php/delete.php?delete">Clear All</a>
            </div>
            <div class="urls-area">
                <div class="title">
                    <li>Shorten URL</li>
                    <li>Original URL</li>
                    <li>Clicks</li>
                    <li>Action</li>
                </div>


                <?php

                while ($row = mysqli_fetch_assoc($sql2)) {
                ?>
                    <div class="data">

                        <li><a href="http://localhost/url/<?= $row['shorten_ul']; ?>" target="_blank">
                                <?php
                                if ('localhost/url/' . $row['shorten_ul'] > 35) {
                                    echo 'localhost/url/' . substr($row['shorten_ul'], 0, 35);
                                } else {
                                    echo 'localhost/url/' . $row['shorten_ul'];
                                }
                                ?>
                            </a></li>
                        <li>
                            <?php
                            if (strlen($row['full_url']) > 35) {
                                echo substr($row['full_url'], 0, 35) . "....";
                            } else {

                                echo $row['full_url'];
                            }
                            ?>
                        </li>
                        <li><?= $row['clicks'] ?></li>
                        <li><a href="php/delete.php?del=<?= $row['shorten_ul']; ?>">Delete</a></li>
                    </div>
            <?php
                }
            }
            ?>

            </div>
    </div>
    <div class="blur-effect"></div>
    <div class="popup-box">
        <div class="info-box">
            Your shor link is ready. You can also edit yout short link now but can't edit once saved it.
        </div>
        <form>
            <label for="">Edit your shorten url</label>
            <input type="text" spellcheck="false" value="example.com/xyz234">
            <i class="copy-icon uil uil-copy-alt"></i>
            <button>Saved</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>

</html>
<?php
session_start();
date_default_timezone_set('Europe/Moscow');
include 'connectdb.php';
include 'guard.php';

if (isset($_GET['exit'])) {
    $_SESSION = [];
}

if (!isset($_SESSION['uid'])) {
    $_SESSION['role'] = 0;
}

?>

<!DOCTYPE html>

<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>МЕГАОМ</title>

    <link rel="shortcut icon" href="img/favicon.svg" type="image/svg">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="wrapper">

        <div class="wrapper__container">

            <?php

                include('incl/header.php');

                if(isset($_GET['p'])) {

                    if($_GET['p'] == 'cataloge') {

                        include('incl/cataloge.php');

                    }

                    else if($_GET['p'] == 'profile') {

                        include('incl/profile.php');

                    }

                    else if($_GET['p'] == 'cart') {

                        include('incl/cart.php');

                    }

                    else if($_GET['p'] == 'status') {

                        include('incl/status.php');

                    }

                    else if($_GET['p'] == 'admin-panel') {

                        include('incl/admin-panel.php');

                    }

                    else if($_GET['p'] == 'users') {

                        include('incl/users.php');

                    }

                    else if ($_GET['p'] == 'products') {
                        include('incl/products.php');
                    }

                    else if ($_GET['p'] == 'one-request') {
                        include('incl/one-request.php');
                    }

                } else {

                    include('incl/start.php');

                }

                include('incl/footer.php');

                include('incl/modals.php');

            ?>

        </div>

    </div>

</body>

</html>
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
                        if(isset($_SESSION['uid'])) {
                            include('incl/profile.php');
                        } else {
                            ?><script>document.location.href="?"</script><?php
                        }
                    }

                    else if($_GET['p'] == 'cart') {
                        if(isset($_SESSION['uid'])) {
                            include('incl/cart.php');
                        } else {
                            ?><script>document.location.href="?"</script><?php
                        }

                    }

                    else if($_GET['p'] == 'status') {
                        if(isset($_SESSION['uid'])) {
                            include('incl/status.php');
                        } else {
                            ?><script>document.location.href="?"</script><?php
                        }
                    }

                    else if($_GET['p'] == 'admin-panel') {
                        if(isset($_SESSION['uid'])) {
                            include('incl/admin-panel.php');
                        } else {
                            ?><script>document.location.href="?"</script><?php
                        }
                    }
                    else if($_GET['p'] == 'users') {
                        if(isset($_SESSION['uid'])) {
                            include('incl/users.php');
                        } else {
                            ?><script>document.location.href="?"</script><?php
                        }
                    }

                    else if ($_GET['p'] == 'products') {
                        include('incl/products.php');
                    }

                    else if ($_GET['p'] == 'one-request') {
                        if(isset($_SESSION['uid'])) {
                            include('incl/one-request.php');
                        } else {
                            ?><script>document.location.href="?"</script><?php
                        }
                    }

                    else if ($_GET['p'] == 'add-master') {
                        if(isset($_SESSION['uid'])) {
                            include('incl/add-master.php');
                        } else {
                            ?><script>document.location.href="?"</script><?php
                        }
                    } else {
                        ?><script>document.location.href="?"</script><?php
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
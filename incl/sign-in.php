<?php
session_start();
include '../connectdb.php';

function validate() {
    if (empty($_POST['email'])) {
        return 'Укажите Email';
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        return 'Укажите корректный email';
    }

    if (!isExistPDO('user', ['email' => $_POST['email']])) {
        return 'Такой Email не зарегистрирован';
    }

    if (empty($_POST['password'])) {
        return 'Укажите пароль';
    }

}


if (isset($_POST['sign-in'])) {
    $msg = validate();

    if (!isset($msg)) {
        $sql = "SELECT * FROM user WHERE email = :email";
        $params = [
            'email' => $_POST['email']
        ];
    
        $prepare = $conn->prepare($sql);
        $prepare->execute($params);

        $user = $prepare->fetch(PDO::FETCH_ASSOC);

        if (password_verify($_POST['password'], $user['password'])) {
            if ($user['is_ban'] == 0) {
                $_SESSION['uid'] = $user['id'];
                $_SESSION['role'] = $user['role_id'];
                header('Location: ../?p=profile');
                die();  
            } else {
                $msg = 'Вы забанены';
                die();
            }

        } else {
            $msg = 'Неверный пароль';
        }
    }


}
?>

<!DOCTYPE html>

<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>МЕГАОМ</title>

    <link rel="shortcut icon" href="../img/favicon.svg" type="image/svg">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <div class="bg"></div>

    <div class="wrapper__auth">

        <div class="wrapper__container auth__container">

            <div class="wrapper__content">

                <div class="content__left__body">

                    <h1 class="content__left__header">Добро пожаловать!</h1>

                    <p class="content__left__text">Нет аккаунта? Так создайте его!</p>

                    <a class="content__left__button button button__auth" href="../incl/sign-up.php">Создать</a>

                    <a href="../" class="on-main">На главную</a>

                </div>

                <div class="content__right__body">

                    <h1 class="content__right__header">Авторизация</h1>
                    <div class="msg <?= !isset($msg) ? 'msg_hide' : '' ?>"><?= $msg ?? '' ?></div>

                    <form action="#" class="content__right__form form" name="sign-in" method="POST" style="margin-top: 0">

                        <input type="text" class="form__input" placeholder="Email" name="email" value="<?= $_POST['email'] ?? '' ?>">

                        <div class="form__password">

                            <input type="password" id="password__input" class="form__input" placeholder="Пароль" name="password" value="<?= $_POST['password'] ?? '' ?>">

                        </div>

                        <input name="sign-in" type="submit" class="form__input submit" value="Войти">

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
<style>
    .msg {
        width: 450px;
        border-radius: 10px;
        background: #FE495A;
        color: #fff;
        font-size: 14px;
        text-align: center;
        padding: 14px 20px;
        margin: 20px 0;
    }

    .msg_hide {
        width: 0;
        height: 0;
        padding: 0;
        overflow: hidden;
    }
</style>
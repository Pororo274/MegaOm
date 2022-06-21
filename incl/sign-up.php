<?php
session_start();
include '../connectdb.php';

function validate() {
    if (empty($_POST['fio'])) {
        return 'Заполните ФИО';
    }

    if (empty($_POST['email'])) {
        return 'Укажите Email';
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        return 'Укажите корректный email';
    }

    if (isExistPDO('user', ['email' => $_POST['email']])) {
        return 'Такой Email уже зарегистрирован';
    }

    if (empty($_POST['password'])) {
        return 'Укажите пароль';
    }

    if (empty($_POST['password_confirm'])) {
        return 'Подтвердите пароль';
    }

    if ($_POST['password'] != $_POST['password_confirm']) {
        return 'Пароли не совпадают';
    }
}

if (isset($_POST['sign-up'])) {
    $msg = validate();

    if (!isset($msg)) {
        $params = [
            'fio' => $_POST['fio'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role_id' => 1,
            'email' => $_POST['email']
        ];

        insertPDO('user', $params);
        echo "<script>location.href='sign-in.php'</script>";
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
                        <a href="../" class="on-main" style="font-size: 18px; font-weight: 700">На главную</a>

                        <h1 class="content__left__header">Добро пожаловать!</h1>

                        <p class="content__left__text reg__text">Чтобы оставаться на связи с нами, пожалуйста, войдите в систему, указав свои личные данные.</p>

                        <a class="content__left__button button__auth" href="../incl/sign-in.php">Войти</a>

                    </div>

                    <div class="content__right__body">

                        <h1 class="content__right__header">Регистрация</h1>
                        <div class="msg <?= !isset($msg) ? 'msg_hide' : '' ?>"><?= $msg ?? '' ?></div>

                        <form action="" method="POST" name="sign-up" class="content__right__form form" style="margin-top: 0">

                        <input type="text" class="form__input" placeholder="ФИО" name="fio" value="<?= $_POST['fio'] ?? '' ?>" required>

                            <input type="text" class="form__input" placeholder="Email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>

                            <div class="form__password">

                                <input type="password" id="password__input" class="form__input" placeholder="Пароль" name="password" maxlength="127" value="<?= $_POST['password'] ?? '' ?>" required>

                            </div>

                            <div class="form__password">

                                <input type="password" id="password__input2" class="form__input" placeholder="Подтвердите пароль" name="password_confirm" maxlength="127" value="<?= $_POST['password_confirm'] ?? '' ?>" required>

                            </div>

                            <input type="submit" class="form__input submit" value="Создать" name="sign-up">

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
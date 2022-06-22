<?php
require 'service.php';

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

if (isset($_POST['add-master'])) {
    $msg = validate();

    if (!isset($msg)) {
        $params = [
            'fio' => $_POST['fio'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role_id' => 3,
            'email' => $_POST['email'],
        ];

        insertPDO('user', $params);
        echo "<script>location.href='?p=admin-panel'</script>";
    }
}
?>

<div class="page__status status">
	<div class="status__container container">
		<h1 class="content__right__header" style="margin-bottom: 30px;">Добавление нового мастера</h1>
        <div class="msg <?= !isset($msg) ? 'msg_hide' : '' ?>" style="margin: auto; margin-bottom: 20px;"><?= $msg ?? '' ?></div>

        <form action="" method="POST" name="add-master" class="content__right__form form" style="margin-top: 0">

        	<input type="text" class="form__input" placeholder="ФИО" name="fio" value="<?= $_POST['fio'] ?? '' ?>" required>

            <input type="text" class="form__input" placeholder="Email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>

            <div class="form__password">

                <input type="password" id="password__input" class="form__input" placeholder="Пароль" name="password" maxlength="127" value="<?= $_POST['password'] ?? '' ?>" required>

            </div>

            <div class="form__password">

                <input type="password" id="password__input2" class="form__input" placeholder="Подтвердите пароль" name="password_confirm" maxlength="127" value="<?= $_POST['password_confirm'] ?? '' ?>" required>

            </div>


            <input type="submit" class="form__input submit" value="Создать" name="add-master">

        </form>
	</div>
</div>
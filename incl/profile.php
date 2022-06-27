<?php

if (!isCanSee($_SESSION['role'], [1, 2, 3])) {
    header('Location: ?p=start');
    die();
}

if (isset($_POST['update-fio'])) {
    if (!empty($_POST['fio'])) {
        $sql = "UPDATE user SET fio = :fio WHERE id = :id";
        $params = [
            'fio' => $_POST['fio'],
            'id' => $_SESSION['uid']
        ];

        $prepare = $conn->prepare($sql);
        $prepare->execute($params);
    }
}

$sql = "SELECT * FROM user WHERE id = :id";
$params = [
    'id' => $_SESSION['uid']
];

$prepare = $conn->prepare($sql);
$prepare->execute($params);
$user = $prepare->fetch(PDO::FETCH_ASSOC);

if (isset($user['avatar'])) {
    $path = 'uploads/avatars/' . $user['avatar'];
} else {
    $path = 'img/avatar/avatar.jpg';
}

?>

<div class="page__profile profile">

    <div class="profile__container container">

        <div class="title__row">

            <h1 class="title__profile">Личный кабинет</h1>

            <div class="profile__buttons">

                <?php

                if ($_SESSION['role'] == 1) {
                    ?>
                    <a href="?p=status&s=2" class="start__button button">Заявки</a>
                    <?php
                }

                ?>

                

                <?php
                if ($_SESSION['role'] == 2) {
                    ?>
                    <a href="?p=admin-panel&s=2" class="start__button button">Админ панель</a>
                    <?php
                }

                ?>

                <?php
                if ($_SESSION['role'] == 3) {
                    ?>
                    <a href="?p=admin-panel&s=2" class="start__button button">Список работ</a>
                    <?php
                }

                ?>

                

            </div>

        </div>


        <div class="profile__content">

            <form class="profile__avatar" name="avatar_add" method="POST" enctype="multipart/form-data">

                <div class="avatar__img">

                    <img src="<?= $path ?>" alt="avatar" id="avatar">

                </div>

                <div class="avatar__row">

                    <input type="file" id="avatar__file" class="hidden__avatar" name="avatar_file" required>

                    <label for="avatar__file" class="avatar__change">

                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">

                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.9037 7.29677C1.9037 10.341 4.1109 12.4147 6.58942 12.8439C6.87304 12.893 7.06315 13.1627 7.01404 13.4464C6.96493 13.73 6.6952 13.9201 6.41157 13.871C3.49991 13.3668 0.861328 10.9127 0.861328 7.29677C0.861328 5.76009 1.56045 4.55245 2.37688 3.63377C2.96173 2.97568 3.63083 2.44135 4.16895 2.03202L2.53254 2.03202C2.2564 2.03202 2.03254 1.80816 2.03254 1.53202C2.03254 1.25588 2.2564 1.03202 2.53254 1.03202L5.53254 1.03202C5.80868 1.03202 6.03254 1.25588 6.03254 1.53202L6.03254 4.53202C6.03254 4.80816 5.80868 5.03202 5.53254 5.03202C5.2564 5.03202 5.03254 4.80816 5.03254 4.53202L5.03254 2.68645L5.03103 2.68759L5.03094 2.68766L5.03093 2.68767L5.03092 2.68767C4.45945 3.11868 3.76108 3.64538 3.15603 4.3262C2.44151 5.13021 1.9037 6.10154 1.9037 7.29677ZM13.0113 7.70321C13.0113 4.69115 10.8509 2.6296 8.40432 2.17029C8.12142 2.11718 7.93514 1.84479 7.98825 1.56188C8.04136 1.27898 8.31375 1.0927 8.59665 1.14581C11.4709 1.68541 14.0537 4.12605 14.0537 7.70321C14.0537 9.23988 13.3546 10.4475 12.5382 11.3662C11.9533 12.0243 11.2842 12.5586 10.7461 12.968L12.3825 12.968C12.6587 12.968 12.8825 13.1918 12.8825 13.468C12.8825 13.7441 12.6587 13.968 12.3825 13.968L9.38254 13.968C9.1064 13.968 8.88254 13.7441 8.88254 13.468L8.88254 10.468C8.88254 10.1918 9.1064 9.96796 9.38254 9.96796C9.65868 9.96796 9.88254 10.1918 9.88254 10.468L9.88254 12.3135L9.88411 12.3123C10.4556 11.8813 11.154 11.3546 11.759 10.6738C12.4735 9.86976 13.0113 8.89844 13.0113 7.70321Z" fill="white"/>

                        </svg>

                    </label>

                </div>

            </form>

            <div class="profile__info">

                <h3 class="profile__title">Общая информация</h3>

                <p class="profile__subtitle"></p>

                <form name="change_fio" class="user__profile" method="POST">

                    <div class="profile__row">

                        <div class="profile__input">

                            <label for="profile__name">ФИО</label>
                            <form class="form" name="update-fio" method="POST">
                                <input type="text" class="form__input" placeholder="ФИО" name="fio" value="<?= $user['fio'] ?>">
                                <input type="submit" class="form__input submit" value="Сохранить" name="update-fio">
                            </form>

                        </div>             

                    </div>
                </form>

                <form name="change_email" class="user__profile change__password" method="POST" style="margin-bottom: 20px">

                    <div class="profile__row">
                        <div class="profile__input">

                            <label for="profile__name">Email</label>

                            <div class="profile__name"><?= $user['email'] ?></div>

                        </div>

                    </div>

                </form>
                <a href="?exit" class="exit">Выйти</a>

            </div>

        </div>

    </div>

</div>

<script>
    let inputFile = document.getElementById('avatar__file');
    let avatar = document.getElementById('avatar');

    inputFile.addEventListener('change', async e => {
        if (e.target.files[0] != null) {
            let form = new FormData();

            form.append('img', e.target.files[0], e.target.files[0].name);

            let res = await fetch('load-avatar.php', {
                method: 'POST',
                body: form
            });

            let data = await res.json();
            avatar.src = 'uploads/avatars/' + data.img;
        }
    })


</script>
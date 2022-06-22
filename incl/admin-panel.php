<?php
if (!isCanSee($_SESSION['role'], [2, 3])) {
    die();
}

if (isset($_GET['accept'])) {
    $sql = "UPDATE request SET status_id = 3 WHERE id = :id";
    $params = [
        'id' => $_GET['id']
    ];
    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
}

if (isset($_GET['remove'])) {
    $sql = "UPDATE request SET status_id = 1 WHERE id = :id";
    $params = [
        'id' => $_GET['id']
    ];
    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
}

if (isset($_POST['add-work'])) {
    $sql = "UPDATE request SET worker_id = :worker_id WHERE id = :id";
    $params = [
        'worker_id' => $_POST['worker'],
        'id' => $_POST['request_id']
    ];

    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
}

$status = $_GET['s'] ?? 1;

$params = [
    'status_id' => $status
];

if ($_SESSION['role'] == 2) {
    $sql = "SELECT request.id AS id, request.create_date AS create_date, status.name AS name FROM request
            JOIN status ON request.status_id = status.id
            WHERE status_id = :status_id AND worker_id IS NULL";
} else {
    $sql = "SELECT request.id AS id, request.create_date AS create_date, status.name AS name FROM request
        JOIN status ON request.status_id = status.id
        WHERE status_id = :status_id AND worker_id = :id";
    $params['id'] = $_SESSION['uid'];
}

$prepare = $conn->prepare($sql);
$prepare->execute($params);

?>

<div class="page__status status">

    <div class="status__container container">

        <div class="title__row">

            <h1 class="title__status">Админ панель</h1>
            <div class="title__row">

                <?php

                if ($_SESSION['role'] == 2) {
                    ?>
                    <a href="?p=add-master" class="start__button button" style="width: initial; display: inline-block; padding: 15px 30px">Добавить мастера</a>
                    <?php
                }

                if ($_SESSION['role'] == 2) {?>
                    <a href="?p=users" class="start__button button">Пользователи</a>
                <?}
                ?>
            </div>

            

        </div>

        <div class="status__list">

        <a href="?p=admin-panel&s=1" class="status__item">Отклоненные</a>

        <a href="?p=admin-panel&s=2" class="status__item">В модерации</a>

        <a href="?p=admin-panel&s=3" class="status__item">Принятые</a>

        </div>

        <div class="cart__form">

            <div class="cart__table-div">

                <table class="cart__table">

                    <tr>

                        <th>Код заказа</th>

                        <th>Дата заказа</th>

                        <th>Статус</th>

                        <?php

                        if ($status == 2) {
                            ?>
                            <th>Управление</th>

                            <?php
                        }

                        ?>

                        
                    </tr>
                    <?php
                    while ($request = $prepare->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>

                            <td>#<?= $request['id'] ?></td>

                            <td><?= date('d.m.Y', $request['create_date']) ?></td>

                            <td><?= $request['name'] ?></td>

                            <?php

                            if ($request['name'] == 'В модерации') {
                                ?>
                                <td>

                                    <div class="control" style="align-items: center">

                                    <?php

                                    if ($_SESSION['role'] == 3) {
                                        ?>
                                        <a href="?p=admin-panel&id=<?= $request['id'] ?>&accept" class="cataloge-item__add-to-cart admin-panel__icon master-panel__icon">

                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"

                                            width="15px" height="15px" viewBox="0 0 512.000000 512.000000"

                                            preserveAspectRatio="xMidYMid meet">

                                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"

                                                fill="#333" stroke="none">

                                                    <path d="M4090 4211 c-14 -5 -41 -16 -60 -25 -19 -10 -502 -484 -1073 -1054

                                                    l-1037 -1037 -398 397 c-272 271 -411 403 -442 419 -68 34 -177 38 -255 8 -51

                                                    -19 -77 -40 -181 -143 -144 -145 -167 -184 -168 -296 -2 -144 -39 -99 678

                                                    -819 436 -438 654 -649 681 -662 51 -24 119 -24 170 0 28 13 434 413 1321

                                                    1302 1430 1432 1320 1311 1318 1459 -1 112 -24 151 -168 296 -102 102 -130

                                                    124 -179 142 -59 22 -156 28 -207 13z"/>

                                                </g>

                                            </svg>

                                        </a>
                                        <?php
                                    }

                                    if ($_SESSION['role'] == 2) {
                                        ?>
                                        <form action="" class="form" name="add-work" method="POST">
                                            <div class="title__row admin__row">
                                                <input type="text" class="form__input submit" value="<?= $request['id'] ?>" name="request_id" style="display: none; position: absolute;">
                                                <select name="worker" id="" class="form__input">
                                                    <?php

                                                    $sql = "SELECT id, fio FROM user WHERE role_id = 3";
                                                    $prepareWorker = $conn->prepare($sql);
                                                    $prepareWorker->execute();

                                                    while ($worker = $prepareWorker->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?= $worker['id'] ?>" selected><?= $worker['fio'] ?></option>
                                                        <?php
                                                    }

                                                    ?>
                                                </select>
                                                <input type="submit" class="form__input submit" value="Добавить" name="add-work">
                                                <a href="?p=admin-panel&id=<?= $request['id'] ?>&remove" class="cataloge-item__add-to-cart admin-panel__icon">

                                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"

                                                    width="10px" height="10px" viewBox="0 0 512.000000 512.000000"

                                                    preserveAspectRatio="xMidYMid meet">

                                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"

                                                        fill="#333" stroke="none">

                                                        <path d="M395 5076 c-170 -41 -316 -188 -355 -356 -28 -120 -7 -261 54 -364

                                                        14 -23 419 -435 900 -916 l876 -875 -888 -890 c-956 -958 -930 -929 -967

                                                        -1070 -29 -115 -13 -234 47 -347 94 -177 315 -263 549 -214 140 30 103 -3

                                                        1054 947 484 483 885 879 890 879 5 0 406 -395 890 -879 816 -815 885 -881

                                                        945 -909 207 -96 457 -57 600 94 135 142 166 360 78 543 -29 61 -99 133 -927

                                                        958 l-896 891 871 874 c543 544 881 890 897 918 44 78 60 152 55 259 -6 115

                                                        -30 185 -93 269 -123 163 -346 232 -540 166 -111 -37 -161 -84 -1029 -953

                                                        l-850 -850 -875 872 c-941 936 -918 916 -1056 952 -69 18 -160 18 -230 1z"/>

                                                        </g>

                                                    </svg>

                                                </a>
                                            </div>
                                        </form>
                                        <?php
                                    }

                                    ?>

                                    </div>

                                </td>
                                <?php
                            }
                            
                            ?>
                            <td>
                                <?php
                                    if ($_SESSION['role'] > 2) {?>

                                        <a href="?p=one-request&id=<?= $request['id'] ?>" class="more">
                                                    Подробнее
                                        </a>
                                    <?}
                                ?>                                     
                            </td>
                            <?

                            ?>
                            

                        </tr>
                    <?php
                    }
                    ?>

                </table>

            </div>

        </div>

    </div>

</div>
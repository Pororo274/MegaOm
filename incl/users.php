<?php
if (!isCanSee($_SESSION['role'], [2])) {
    die();
}

if (isset($_GET['ban'])) {

    $sql = "UPDATE user SET is_ban=1 WHERE id = :id";

    $params = [
        'id' => $_GET['ban']
    ];
    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
}


if (isset($_GET['return'])) {
    $sql = "UPDATE user SET is_ban=0 WHERE id = :id";

    $params = [
        'id' => $_GET['return']
    ];
    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
}

$sql = "SELECT * FROM user";
$prepare = $conn->prepare($sql);
$prepare->execute();

?>

<div class="page__users users">

    <div class="users__container container">

        <div class="title__row">

            <h1 class="title__status">Админ панель</h1>

        </div>

        <form name="order" class="cart__form">

            <div class="cart__table-div">

                <table class="cart__table">

                    <tr>

                        <th>Код пользователя</th>

                        <th>ФИО</th>

                        <th>Email</th>

                    </tr>
                    <?php

                    while ($user = $prepare->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>

                            <td>#<?= $user['id'] ?></td>

                            <td><?= $user['fio'] ?></td>

                            <td><?= $user['email'] ?></td>

                            <?php

                            if ($user['role_id'] != 2) {
                                
                                if ($user['is_ban'] == 0) {
                                    ?>
                                    <td><a class="ban__link" href="?p=users&ban=<?= $user['id'] ?>">Заблокировать</a></td>
                                    <?php
                                } else {
                                    ?>
                                    <td><a class="ban__link" href="?p=users&return=<?= $user['id'] ?>">Разблокировать</a></td>
                                    <?php                                    
                                }
                                ?>

                                <?php
                            } else {
                                ?>
                                <td></td>
                                <?php
                            }

                            ?>

                            

                        </tr>
                        <?php
                    }

                    ?>


                </table>

            </div>

        </form>

    </div>

</div>
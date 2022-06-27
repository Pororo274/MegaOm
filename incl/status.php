<?php
$status = $_GET['s'] ?? 1;

if (isset($_GET['remove'])) {
    $sql = "UPDATE request SET status_id = 1 WHERE id = :id";
    $params = [
        'id' => $_GET['remove']
    ];
    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
    echo "<script>document.href='?p=status&s=2'</script>";
}

$sql = "SELECT request.id AS id, request.create_date AS create_date, status.name AS name FROM request
        JOIN status ON request.status_id = status.id
        WHERE user_id = :user_id AND status_id = :status_id";
$params = [
    'user_id' => $_SESSION['uid'],
    'status_id' => $status
];

$prepare = $conn->prepare($sql);
$prepare->execute($params);

?>

<div class="page__status status">

    <div class="status__container container">

        <h1 class="title__status">Статус заявки</h1>

        <div class="status__list">

            <a href="?p=status&s=1" class="status__item">Отклоненные</a>

            <a href="?p=status&s=2" class="status__item">В модерации</a>

            <a href="?p=status&s=3" class="status__item">Выполненные</a>

        </div>

        <form name="order" class="cart__form">

            <div class="cart__table-div cart__status-table-div">

                <table class="cart__table">

                    <tr>

                        <th>Код заказа</th>

                        <th>Дата заказа</th>

                        <th>Статус</th>

                    </tr>

                    <?php
                    while ($request = $prepare->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>

                        <td>#<?= $request['id'] ?></td>

                        <td><?= date('d.m.Y', $request['create_date']) ?></td>

                        <td><!--$request['name']-->Выполнено</td>

                        <td><a href="?p=one-request&id=<?= $request['id'] ?>" class="more">Подробнее</a></td>

                        <?php

                        if ($_GET['s'] == 2) {
                            ?>
                            <td><a href="?p=status&remove=<?= $request['id'] ?>&s=2" class="more">Отклонить</a></td>
                            <?php
                        }

                        ?>
                        
                        <!-- 
                        <td>

                            <a href="#" class="cataloge-item__add-to-cart admin-panel__icon">

                                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"

                                width="15px" height="15px" viewBox="0 0 512.000000 512.000000"

                                preserveAspectRatio="xMidYMid meet">

                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"

                                    fill="#333" stroke="none">

                                        <path d="M381 3054 c-216 -58 -381 -271 -381 -494 0 -177 113 -366 269 -449

                                        200 -106 441 -71 599 87 104 104 152 219 152 362 0 143 -48 258 -152 362 -125

                                        125 -318 178 -487 132z"/>

                                        <path d="M2433 3055 c-179 -48 -321 -193 -368 -372 -69 -266 100 -547 372

                                        -618 266 -69 547 100 618 372 69 266 -100 547 -372 618 -71 19 -181 18 -250 0z"/>

                                        <path d="M4485 3056 c-171 -43 -326 -195 -370 -363 -46 -178 5 -363 137 -495

                                        244 -244 657 -175 810 134 78 157 78 299 0 456 -104 211 -349 325 -577 268z"/>

                                    </g>

                                </svg>

                            </a>

                        </td> -->

                        </tr>
                        <?php
                    }



                    ?>

                    

                </table>

            </div>

        </form>

    </div>

</div>
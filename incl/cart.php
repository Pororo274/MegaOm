<script src="js/script.js"></script>
<?php

function validate() {
    if (empty($_POST['fio'])) {
        return 'Укажите ФИО';
    }

    if (empty($_POST['phone'])) {
        return 'Укажите телефон';
    }

    if (strlen($_POST['phone']) < 17) {
        return 'Укажите корректный телефон';
    }
}


if (isset($_POST['order'])) {
    $msg = validate();

    if (!isset($msg)) { 
        $params = [
            'user_id' => $_SESSION['uid'],
            'status_id' => 2,
            'phone' => $_POST['phone'],
            'fio' => $_POST['fio'],
            'create_date' => time()
        ];
        insertPDO('request', $params);

        $sql = "SELECT id FROM request WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
        $prepare = $conn->prepare($sql);
        $params = [
            'user_id' => $_SESSION['uid']
        ];
        $prepare->execute($params);
        $id = $prepare->fetch(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($_POST['id']); $i++) {
            $params = [
                'product_id' => $_POST['id'][$i],
                'count' => $_POST['amount'][$i],
                'request_id' => $id['id']
            ];

            insertPDO('request_product', $params);
        }

        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        $params = [
            'user_id' => $_SESSION['uid']
        ];
        $prepare = $conn->prepare($sql);
        $prepare->execute($params);
    }
}

if (isset($_GET['del'])) {
    $params= [
        'user_id' => $_SESSION['uid'],
        'product_id' => $_GET['del']
    ];

    $sql = "DELETE FROM cart WHERE user_id=:user_id AND product_id=:product_id";
    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
}

if (isset($_GET['id'])) {
    $params= [
        'user_id' => $_SESSION['uid'],
        'product_id' => $_GET['id']
    ];

    try {
        insertPDO('cart', $params);
        echo "<script>location.href='?p=cart'</script>";
    } catch (PDOException $e) {

    }
    
}


$sql = "SELECT * FROM product
        JOIN cart ON product.id = cart.product_id
        WHERE cart.user_id = :id";
$params = [
    'id' => $_SESSION['uid']
];

$prepareCart = $conn->prepare($sql);
$prepareCart->execute($params);

$sql = "SELECT COUNT(*) AS countProduct FROM cart WHERE cart.user_id = :id";
$prepare = $conn->prepare($sql);
$prepare->execute($params);
$count = $prepare->fetch(PDO::FETCH_ASSOC);

?>


<div class="page__cart cart">

    <div class="cart__container container">

        <div class="title__row">

            <h1 class="title__profile">Корзина</h1>

        </div>
        <div class="msg <?= !isset($msg) ? 'msg_hide' : '' ?>"><?= $msg ?? '' ?></div>
        <form name="order" class="cart__form" method="POST" action="?p=cart"> 

            <div class="cart__table-div">


                    <table class="cart__table">

                    <?php

                    if ($count['countProduct'] > 0) {
                        ?>

                        <tr>

                        <th>Услуга</th>

                        <th>Цена</th>

                        <th>Количество</th>

                        <th>Удаление</th>

                        </tr>
                        <?php
                    } else {
                        ?>
                        Корзина пуста :(
                        <?php
                    }

                    ?>



                    <?php

                        while ($product = $prepareCart->fetch(PDO::FETCH_ASSOC)) {
                            ?>

                    <tr>

                        <td><?= $product['name'] ?></td>

                        <td><?= $product['price'] ?> ₽</td>

                        <td>
                            <input type="text" name="id[]" value="<?= $product['id'] ?>" style="width: 0; height: 0; overflow: hidden; position: absolute; display: none">
                            <input class="cart-item__amount" type="number" name="amount[]" value="<?= $product['count'] ?>">

                        </td>

                        <td>

                            <a href="?p=cart&del=<?= $product['id'] ?>" class="cart__delete">

                                <svg width="35" height="35" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">

                                    <circle cx="20" cy="20" r="20" fill="#fff"/>

                                    <path d="M15.369 14.2349C15.0558 13.9217 14.5481 13.9217 14.2349 14.2349C13.9217 14.5481 13.9217 15.0558 14.2349 15.369L18.8659 20L14.2349 24.631C13.9218 24.9441 13.9218 25.4519 14.2349 25.7651C14.5481 26.0782 15.0559 26.0782 15.369 25.7651L20 21.1341L24.631 25.7651C24.9441 26.0782 25.4519 26.0782 25.7651 25.7651C26.0782 25.4519 26.0782 24.9441 25.7651 24.631L21.1341 20L25.7651 15.369C26.0783 15.0558 26.0783 14.5481 25.7651 14.2349C25.4519 13.9217 24.9442 13.9217 24.631 14.2349L20 18.8659L15.369 14.2349Z" fill="#000"/>

                                </svg>

                            </a>

                        </td>

                    </tr>
                    <?php
                    }
                    ?>

                    </table>
  


                

            </div>

            <?php

            if ($count['countProduct'] > 0) {
                ?>
                <div class="cart__result">

                    <div class="cart__form-result">

                        <h4>Для оформления заявки заполните форму</h4>

                        <div class="result__input">

                            <div class="result__info-input">

                                <input class="cart-item__input cart__standart-input" type="text" name="fio" placeholder="ФИО" value="<?= $_POST['fio'] ?? '' ?>">

                                <input class="cart-item__input cart__standart-input tel" type="text" name="phone" placeholder="Телефон" value="<?= $_POST['phone'] ?? '' ?>">

                            </div>

                            <input type="submit" class="cart__submit button" value="Оформить" name="order">

                        </div>

                    </div>

                </div>
                <?php
            }
            ?>

        </form>

    </div>

</div>
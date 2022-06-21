<div class="sign-in__modal" id="sign-in_modal">

    <a href="#">

        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">

            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1564 7.65664C23.3809 7.43208 23.3809 7.06801 23.1564 6.84346C22.9318 6.61891 22.5678 6.61891 22.3432 6.84346L14.9998 14.1869L7.65639 6.84346C7.43184 6.61891 7.06777 6.61891 6.84322 6.84346C6.61867 7.06801 6.61867 7.43208 6.84322 7.65664L14.1866 15L6.84322 22.3435C6.61867 22.568 6.61867 22.9321 6.84322 23.1566C7.06777 23.3812 7.43184 23.3812 7.65639 23.1566L14.9998 15.8132L22.3432 23.1566C22.5678 23.3812 22.9318 23.3812 23.1564 23.1566C23.3809 22.9321 23.3809 22.568 23.1564 22.3435L15.813 15L23.1564 7.65664Z" fill="#fff"></path>

        </svg>

    </a>

    <h2 class="modal__title">Вы не авторизованы</h2>

    <p class="modal__title__subtitle">Для входа в систему нажмите на кнопку войти</p>

    <a href="incl/sign-in.php" class="start__button button">Войти</a>

</div>



<div class="sign-in__modal" id="add_modal">

    <a href="#">

        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">

            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1564 7.65664C23.3809 7.43208 23.3809 7.06801 23.1564 6.84346C22.9318 6.61891 22.5678 6.61891 22.3432 6.84346L14.9998 14.1869L7.65639 6.84346C7.43184 6.61891 7.06777 6.61891 6.84322 6.84346C6.61867 7.06801 6.61867 7.43208 6.84322 7.65664L14.1866 15L6.84322 22.3435C6.61867 22.568 6.61867 22.9321 6.84322 23.1566C7.06777 23.3812 7.43184 23.3812 7.65639 23.1566L14.9998 15.8132L22.3432 23.1566C22.5678 23.3812 22.9318 23.3812 23.1564 23.1566C23.3809 22.9321 23.3809 22.568 23.1564 22.3435L15.813 15L23.1564 7.65664Z" fill="#fff"></path>

        </svg>

    </a>

    <h2 class="modal__title">Добавление услуги</h2>
    <div class="msg <?= !isset($msg) ? 'msg_hide' : '' ?>"><?= $msg ?? '' ?></div>

    <form name="add_item" class="add-modal__form" method="POST" action="">

        <input class="cart__standart-input add-modal__input" type="text" name="name" placeholder="Название услуги" value="<?= $_POST['name'] ?? '' ?>">

        <input class="cart__standart-input add-modal__input" type="number" name="price" placeholder="Цена" value="<?= $_POST['price'] ?? '' ?>">

        <input class="cart__standart-input add-modal__input" type="text" name="unit" placeholder="Единица измерения" value="<?= $_POST['unit'] ?? '' ?>">

        <input type="submit" value="Добавить" name="add_item" class="start__button button add-modal__submit">

    </form>

</div>



<div class="sign-in__modal" id="edit_modal">

    <a href="#">

        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">

            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1564 7.65664C23.3809 7.43208 23.3809 7.06801 23.1564 6.84346C22.9318 6.61891 22.5678 6.61891 22.3432 6.84346L14.9998 14.1869L7.65639 6.84346C7.43184 6.61891 7.06777 6.61891 6.84322 6.84346C6.61867 7.06801 6.61867 7.43208 6.84322 7.65664L14.1866 15L6.84322 22.3435C6.61867 22.568 6.61867 22.9321 6.84322 23.1566C7.06777 23.3812 7.43184 23.3812 7.65639 23.1566L14.9998 15.8132L22.3432 23.1566C22.5678 23.3812 22.9318 23.3812 23.1564 23.1566C23.3809 22.9321 23.3809 22.568 23.1564 22.3435L15.813 15L23.1564 7.65664Z" fill="#fff"></path>

        </svg>

    </a>

    <h2 class="modal__title">Редактирование услуги</h2>
    <div class="msg <?= !isset($msg) ? 'msg_hide' : '' ?>"><?= $msg ?? '' ?></div>

    <form name="edit_item" class="add-modal__form" method="POST">

        <input class="cart__standart-input add-modal__input" type="text" name="name" placeholder="Название услуги" value="<?= $item['name'] ?? '' ?>">

        <input class="cart__standart-input add-modal__input" type="number" name="price" placeholder="Цена" value="<?= $item['price'] ?? '' ?>">

        <input class="cart__standart-input add-modal__input" type="text" name="unit" placeholder="Единица измерения" value="<?= $item['unit'] ?? '' ?>">

        <input type="submit" value="Сохранить" name="edit_item" class="start__button button add-modal__submit">

    </form>

</div>
<style>
    .msg {
        width: 450px;
        position: static;
        border-radius: 10px;
        background: #FE495A;
        color: #fff;
        font-size: 14px;
        text-align: center;
        padding: 14px 20px;
        margin: 20px 0;
    }

    .msg_hide {
        position: absolute;
        width: 0;
        height: 0;
        padding: 0;
        margin: 0;
        overflow: hidden;
    }
</style>
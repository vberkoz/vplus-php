<?php

return "
<main role='main' class='content container px-4' style='margin-top: 120px;'>
<div class='row'>
<div class='col-md-12 mb-3' id='info_container'>
    <div class='card'>
        <div class='card-body'>
            <h4 class='card-title'>".($lang == "ua" ? "Ваше замовлення" : "Your order")."</h4>
            <p class='card-subtitle mb-4 text-success' id='summary'></p>
            <div class='alert alert-warning' role='alert'>".($lang == "ua" ? "Звертаємо Вашу увагу на те, що вартість замовлення, розрахована на сайті, являється приблизною і може відрізнятися від вартості при оплаті." : "Please note that the cost of the order, calculated on the site, is approximate and may differ from the cost of payment.")."</div>
            <div class='alert alert-info' role='alert'>".($lang == "ua" ? "Сьогодні будуть доставлені замовлення які були оформлені до 4-ї години ранку. Замовлення оформлені після 4-ї години ранку будуть доставлені завтра." : "Orders that were placed before 4 o'clock in the morning will be delivered today. Orders placed after 4 o'clock in the morning will be delivered tomorrow.")."</div>
            <div class='alert alert-light' role='alert'>".($lang == "ua" ? "Щоб оформити замовлення заповніть обов'язкові поля 'Ваше ім'я' та 'Номер телефону' і наш працівник незабаром зв'яжеться з Вами. Також Ви можете вказати адресу доставки та повідомлення для пакувальника." : "To place an order, fill in the required fields 'Your name' and 'Phone number' and our employee will contact you shortly. You can also specify the delivery address and message for the packer.")."</div>
            <hr>
            <div class='form-row'>
                <div class='form-group col-md-4'>
                    <label for='name'>".($lang == "ua" ? "Ваше ім`я" : "Your name")."</label>
                    <input type='text' class='form-control' id='name' placeholder='".($lang == "ua" ? "Ваше ім`я" : "Your name")."' onblur='validate(this)'>
                    <div class='invalid-feedback'>".($lang == "ua" ? "Мінімум 2 символи" : "At least 2 characters")."</div>
                </div>
                <div class='form-group col-md-4'>
                    <label for='phone'>".($lang == "ua" ? "Номер телефону" : "Phone number")."</label>
                    <input type='text' class='form-control' id='phone' placeholder='0661234567' onblur='validate(this)'>
                    <div class='invalid-feedback'>".($lang == "ua" ? "Мінімум 10 цифр" : "At least 10 digits")."</div>
                </div>
                <div class='form-group col-md-4'>
                    <label for='address'>".($lang == "ua" ? "Адреса" : "Address")."</label>
                    <input type='text' class='form-control' id='address' placeholder='".($lang == "ua" ? "Адреса" : "Address")."' onblur='store(this)'>
                </div>
            </div>
            <div class='form-group'>
                <label for='message'>".($lang == "ua" ? "Повідомлення для пакувальника" : "Message for the packer")."</label>
                <textarea class='form-control' id='message' rows='3' onblur='store(this)'></textarea>
                <small class='form-text text-muted'>".($lang == "ua" ? "Ми не передаємо особисту інформацію наших клієнтів іншим сторонам." : "We do not pass personal information of our customers to other parties.")."</small>
            </div>
            <button type='button' class='btn btn-primary' id='checkout' onclick='checkout()'>".($lang == "ua" ? "Оформити замовлення" : "Finish")."</button>
        </div>
    </div>
</div>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script src='https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js'></script>
<script src='https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js'></script>
<script src='$assets/js/main.js'></script>
<script src='$assets/js/categories.js'></script>
<script src='$assets/js/search.js'></script>
<script src='$assets/js/validation.js'></script>
<script src='$assets/js/checkout.js'></script>
";

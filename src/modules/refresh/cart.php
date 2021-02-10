<?php

return "
<main role='main' class='content container px-4' style='margin-top: 120px;'>
<div id='empty' class='w-100 d-none'>
    <div class='d-flex justify-content-center align-items-center w-100' style='height: 200px;'>
        <div class='alert alert-info' role='alert'>".($lang == "ua" ? "Тут немає жодного продукту" : "There are no products here")."</div>
    </div>
</div>
<div id='full' class='row'>
    <div class='col-lg-9 mb-3 p-2'>
        <div class='card'>
            <div class='card-body' id='cart'></div>
        </div>
    </div>
    <div class='col-lg-3 mb-3 p-2'>
        <div class='card'>
            <div class='card-body'>
                <div class='d-flex justify-content-between m-0'>
                    <p class='m-0'>".($lang == "ua" ? "Товари" : "Goods").":</p>
                    <p class='m-0' id='cart_price'></p>
                </div>
                <div class='d-flex justify-content-between m-0'>
                    <p class='m-0'>".($lang == "ua" ? "Знижка" : "Discount").":</p>
                    <p class='m-0 text-danger' id='cart_discount'></p>
                </div>
                <div class='d-flex justify-content-between m-0'>
                    <p class='m-0'>".($lang == "ua" ? "Всього" : "Total").":</p>
                    <p class='m-0'><b id='cart_total'></b></p>
                </div>
                <hr>
                <a href='$dir/checkout.html' class='btn btn-primary btn-block'>".($lang == "ua" ? "Замовити" : "Order")."</a>
            </div>
        </div>
    </div>
    
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script src='https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js'></script>
<script src='https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js'></script>
<script src='$assets/js/main.js'></script>
<script src='$assets/js/categories.js'></script>
<script src='$assets/js/search.js'></script>  
<script src='$assets/js/cart.js'></script>
";

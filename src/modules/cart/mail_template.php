<?php

return $header = "
<!doctype html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta name='description' content=''>
    <meta name='author' content=''>
    <link rel='icon' type='image/svg+xml' href='/favicon.svg'>

    <title>Mail Template</title>

    <link rel='canonical' href='https://getbootstrap.com/docs/4.0/examples/navbar-fixed/'>

    <!-- Bootstrap core CSS -->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>

    <!-- Custom styles for this template -->
    <link rel='stylesheet' href='$domain/public/assets/css/public.css'>
</head>

<body style='background-color: #f5f5f5;'>

<main role='main' class='content container-fluid p-4'>
    <div class='row'>
        <div class='card col-12 p-0'>
            <header class='card-header bg-white'>
                <b class='d-inline-block mr-3'>Замовлення: $hash</b>
            </header>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-md-3 pr-lg-4 mb-3'>
                        <h6 class='text-muted'>Оплата</h6>
                        <div class='d-flex justify-content-between'>
                            <span>Товари:</span><span>$cartPrice</span>
                        </div>
                        <div class='d-flex justify-content-between'>
                            <span>Знижка:</span><span class='text-danger'>$cartDiscount</span>
                        </div>
                        <div class='d-flex justify-content-between'>
                            <span>Всього:</span><span>$cartTotal</span>
                        </div>
                    </div>
                    <div class='col-md-3 px-lg-4'>
                        <h6 class='text-muted'>Замовник</h6>
                        <p>$name<br>$phone</p>
                    </div>
                    <div class='col-md-3 px-lg-4'>
                        <h6 class='text-muted'>Адреса</h6>
                        <p>$address</p>
                    </div>
                    <div class='col-md-3 pl-lg-4'>
                        <h6 class='text-muted'>Повідомлення</h6>
                        <p>$message</p>
                    </div>
                </div>
            </div>
            <div class='card-footer bg-white pt-4'>
                <div class='row m-0 p-0'>$items</div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
";

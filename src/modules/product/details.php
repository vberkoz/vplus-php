<?php

$cat_slug = $prod['cat_slug'];
$cat_title = $prod['cat'];
$title = $prod['title'];
$img = $prod['img'];
$code = $prod['code'];
$vol = $prod['vol'];
$unit = $prod['unit'];
$vol_min = $prod['vol_min'];
$id = $prod['id'];

$fmt = numfmt_create( 'uk_UA', NumberFormatter::CURRENCY );
$price = numfmt_format_currency($fmt, $prod['price'], "UAH");

return $details = "
<main role='main' class='content container-fluid px-4' style='margin-top: 120px;'>
<div class='row'>
<aside class='container-fluid'>
    <div class='row' id='products'>
        <div class='col-md-12 col-xl-8 offset-xl-2 p-1'>
            <nav class='card' aria-label='breadcrumb'>
                <ol class='breadcrumb m-0' style='background-color: rgba(255, 255, 128, .0)'>
                    <li class='breadcrumb-item'><a href='$dir/index.html'>".($lang == "ua" ? "Головна" : "Main")."</a></li>
                    <li class='breadcrumb-item'><a href='$dir/category/$cat_slug.html'>$cat_title</a></li>
                    <li class='breadcrumb-item active' aria-current='page'>$title</li>
                </ol>
            </nav>
        </div>

        <div class='col-md-6 col-xl-4 offset-xl-2 p-1'>
            <div class='card h-100'>
                <div class='card-body d-flex align-items-center'>
                    <img class='align-middle mx-auto d-block img-fluid'
                         src='../img/$img' alt='$title'>
                </div>
            </div>
        </div>

        <div class='col-md-6 col-xl-4 p-1'>
            <div class='card'>
                <div class='card-body'>
                    <p class='text-muted'><small><strong>".($lang == "ua" ? "Код товару" : "Product code").": $code</strong></small></p>
                    <h1 class='card-title'><strong>$title</strong></h1>
                    <p class='text-muted'>
                        <small>".($lang == "ua" ? "Ціна за" : "Price for")." $vol $unit</small><br>
                        <small>".($lang == "ua" ? "Мін. замовлення" : "Min. order")." $vol_min $unit</small>
                    </p>

                    <div>
                        <div class='h1'>$price</div>
                        <div class='d-flex flex-column justify-content-between'>
                            <a href='#' class='add-to-bag-first btn btn-outline-primary'
                               data-id='$id' data-unit='$unit'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 426.667 426.667' height='1em' fill='currentColor'>
                                    <path d='M128,341.333c-23.573,0-42.453,19.093-42.453,42.667s18.88,42.667,42.453,42.667c23.573,0,42.667-19.093,42.667-42.667     S151.573,341.333,128,341.333z'/>
                                    <path d='M151.467,234.667H310.4c16,0,29.973-8.853,37.333-21.973L424,74.24c1.707-2.987,2.667-6.507,2.667-10.24     c0-11.84-9.6-21.333-21.333-21.333H89.92L69.653,0H0v42.667h42.667L119.36,204.48l-28.8,52.267     c-3.307,6.187-5.227,13.12-5.227,20.587C85.333,300.907,104.427,320,128,320h256v-42.667H137.067     c-2.987,0-5.333-2.347-5.333-5.333c0-0.96,0.213-1.813,0.64-2.56L151.467,234.667z'/>
                                    <path d='M341.333,341.333c-23.573,0-42.453,19.093-42.453,42.667s18.88,42.667,42.453,42.667     C364.907,426.667,384,407.573,384,384S364.907,341.333,341.333,341.333z'/>
                                </svg> ".($lang == "ua" ? "Покласти в кошик" : "Add to Cart")."
                            </a>

                            <div class='input-group d-none'>
                                <div class='input-group-prepend'>
                                    <button type='button' class='btn btn-primary remove-from-bag'
                                        data-id='$id' data-volume_min='$vol_min' data-unit='$unit'>
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 459 459' height='0.8em'
                                             fill='currentColor' class='align-middle'>
                                            <path d='M459.313,229.648c0,22.201-17.992,40.199-40.205,40.199H40.181c-11.094,0-21.14-4.498-28.416-11.774   C4.495,250.808,0,240.76,0,229.66c-0.006-22.204,17.992-40.199,40.202-40.193h378.936   C441.333,189.472,459.308,207.456,459.313,229.648z'/>
                                        </svg>
                                    </button>
                                </div>
                                <input type='text' class='form-control text-center input-float' data-id='$id' data-unit='$unit'>
                                <div class='input-group-append'>
                                    <button type='button' class='btn btn-primary add-to-bag-second'
                                        data-id='$id' data-volume_min='$vol_min' data-unit='$unit'>
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 448' height='0.8em'
                                            fill='currentColor' class='align-middle'>
                                            <path d='m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40 17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844 0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031 8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969 3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0'/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='card mt-2'>
                <div class='card-body'>
                    <h4 class='card-title'>".($lang == "ua" ? "Характеристики" : "Characteristics")."</h4><hr>$char
                </div>
            </div>
        </div>

        <div class='col-md-6 col-xl-4 offset-xl-2 p-1'>
            <div class='card'>
                <div class='card-body'>
                    <h4 class='card-title'>".($lang == "ua" ? "Корисна інформація" : "Useful Information")."</h4><hr>$desc
                </div>
            </div>
        </div>

        <div class='col-md-6 col-xl-4 p-1'>
            <div class='card'>
                <div class='card-body'>
                    <div class='d-flex justify-content-between'>
                        <h4 class='card-title mb-0'>".($lang == "ua" ? "Відгуки" : "Reviews")."</h4>
                        <button type='button' class='btn btn-sm btn-link' data-toggle='modal' data-target='#productReview'>".($lang == "ua" ? "Написати" : "Write")."</button>
                        <div class='modal fade' id='productReview' tabindex='-1' role='dialog' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>".($lang == "ua" ? "Ваш відгук" : "Your review")."</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <form>
                                            <input type='text' id='product_id' class='d-none' value='$id'>
                                            <div class='form-group'>
                                                <label for='reviewer_name'>".($lang == "ua" ? "Ім`я" : "Name")."</label>
                                                <input type='text' class='form-control' id='reviewer_name'
                                                       placeholder='".($lang == "ua" ? "Ім`я" : "Name")."'>
                                            </div>
                                            <div class='form-group'>
                                                <label for='reviewer_email'>".($lang == "ua" ? "Електронна пошта" : "Email")."</label>
                                                <input type='email' class='form-control' id='reviewer_email'
                                                       placeholder='name@example.com'>
                                            </div>
                                            <div class='form-group'>
                                                <label for='reviewer_text'>".($lang == "ua" ? "Відгук" : "Review")."</label>
                                                <textarea class='form-control' id='reviewer_text' rows='3'
                                                          placeholder='".($lang == "ua" ? "Відгук" : "Review")."'></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>".($lang == "ua" ? "Відміна" : "Cancel")."
                                        </button>
                                        <button type='button' class='btn btn-primary' data-dismiss='modal'
                                                onclick='saveReview()'>".($lang == "ua" ? "Зберегти" : "Save")."
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div id='reviews'>$reviews</div>
                </div>
            </div>
        </div>
    </div>
</aside>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script src='https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js'></script>
<script src='https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js'></script>
<script src='//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'></script>
<script src='$assets/js/main.js'></script>
<script src='$assets/js/categories.js'></script>
<script src='$assets/js/search.js'></script>
<script src='$assets/js/card.js'></script>
";

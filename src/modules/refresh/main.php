<?php

if(!function_exists("slider")) {
    function slider($items, $dir, $assets)
    {
        $fmt = numfmt_create('uk_UA', NumberFormatter::CURRENCY);
        $cards = "";
        foreach ($items as $i) {
            $id = $i['id'];
            $slug = $i['slug'];
            $img = $i['img'];
            $title = $i['title'];
            $unit = $i['unit'];
            $vol = $i['vol'];
            $vol_min = $i['vol_min'];
            $price = numfmt_format_currency($fmt, $i['price'], "UAH");

            $cards .= "
            <div class=' pl-1 pr-1 pb-2 product-card' data-id='$id'>
                <div class='card h-100'>
                    <div class='px-4 pt-4'>
                        <a href='$dir/product/$slug.html'>
                            <img class='card-img-top' src='img/$img' alt='$title'>
                        </a>
                    </div>
                    
                    <div class='card-body d-flex flex-column justify-content-between p-3'>
                        <p class='card-text pt-2 mb-2 gradient-text'>$title</p>
                        <div class='d-flex justify-content-between align-items-end pb-4'>$vol $unit
                            <div>
                                <div>
                                    <strong>$price</strong>
                                </div>
                            </div>
                        </div>
                        <a href='#' data-id='$id' data-unit='$unit' class='add-to-bag-first btn btn-outline-primary'>
                            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 426.667 426.667' height='1em' fill='currentColor'>
                                <path d='M128,341.333c-23.573,0-42.453,19.093-42.453,42.667s18.88,42.667,42.453,42.667c23.573,0,42.667-19.093,42.667-42.667     S151.573,341.333,128,341.333z'/>
                                <path d='M151.467,234.667H310.4c16,0,29.973-8.853,37.333-21.973L424,74.24c1.707-2.987,2.667-6.507,2.667-10.24     c0-11.84-9.6-21.333-21.333-21.333H89.92L69.653,0H0v42.667h42.667L119.36,204.48l-28.8,52.267     c-3.307,6.187-5.227,13.12-5.227,20.587C85.333,300.907,104.427,320,128,320h256v-42.667H137.067     c-2.987,0-5.333-2.347-5.333-5.333c0-0.96,0.213-1.813,0.64-2.56L151.467,234.667z'/>
                                <path d='M341.333,341.333c-23.573,0-42.453,19.093-42.453,42.667s18.88,42.667,42.453,42.667     C364.907,426.667,384,407.573,384,384S364.907,341.333,341.333,341.333z'/>
                            </svg>
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
                                <button type='button' data-id='$id' data-volume_min='$vol_min' data-unit='$unit'
                                    class='btn btn-primary add-to-bag-second'>
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
            ";
        }
        return $cards;
    }
}

$new = slider($new, $dir, $assets);
$popular = slider($popular, $dir, $assets);

//<div id='carouselExampleCaptions' class='carousel slide w-100' data-ride='carousel'>
//        <ol class='carousel-indicators'>
//            <li data-target='#carouselExampleCaptions' data-slide-to='0' class=''></li>
//            <li data-target='#carouselExampleCaptions' data-slide-to='1' class=''></li>
//            <li data-target='#carouselExampleCaptions' data-slide-to='2' class='active'></li>
//        </ol>
//        <div class='carousel-inner'>
//            <div class='carousel-item'>
//                <img class='d-block w-100' data-src='holder.js/800x200?auto=yes&amp;bg=777&amp;fg=555&amp;text=First slide' alt='First slide [800x400]' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22300%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_175f58c2591%20text%20%7B%20fill%3A%23555%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_175f58c2591%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22285.921875%22%20y%3D%22217.7%22%3EFirst%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' data-holder-rendered='true'>
//                <div class='carousel-caption d-none d-md-block'>
//                    <h5>First slide label</h5>
//                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
//                </div>
//            </div>
//            <div class='carousel-item'>
//                <img class='d-block w-100' data-src='holder.js/800x200?auto=yes&amp;bg=666&amp;fg=444&amp;text=Second slide' alt='Second slide [800x400]' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22300%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_175f58c2592%20text%20%7B%20fill%3A%23444%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_175f58c2592%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23666%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22247.3125%22%20y%3D%22217.7%22%3ESecond%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' data-holder-rendered='true'>
//                <div class='carousel-caption d-none d-md-block'>
//                    <h5>Second slide label</h5>
//                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
//                </div>
//            </div>
//            <div class='carousel-item active'>
//                <img class='d-block w-100' data-src='holder.js/800x200?auto=yes&amp;bg=555&amp;fg=333&amp;text=Third slide' alt='Third slide [800x400]' src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22300%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_175f58c2593%20text%20%7B%20fill%3A%23333%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_175f58c2593%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23555%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22277%22%20y%3D%22217.7%22%3EThird%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E' data-holder-rendered='true'>
//                <div class='carousel-caption d-none d-md-block'>
//                    <h5>Third slide label</h5>
//                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
//                </div>
//            </div>
//        </div>
//        <a class='carousel-control-prev' href='#carouselExampleCaptions' role='button' data-slide='prev'>
//            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
//            <span class='sr-only'>Previous</span>
//        </a>
//        <a class='carousel-control-next' href='#carouselExampleCaptions' role='button' data-slide='next'>
//            <span class='carousel-control-next-icon' aria-hidden='true'></span>
//            <span class='sr-only'>Next</span>
//        </a>
//    </div>

return "
<main role='main' class='content container-fluid px-4' style='margin-top: 120px;'>
<div class='row'>
<div class='col-sm-12 p-1'>
    
    
    <div id='products'>
        <div class='d-flex justify-content-between px-1 pt-3'>
            <h4 class='pt-2'>".($lang == "ua" ? "Нові" : "New")."</h4>
            <div class='pb-2'>
                <button type='button' class='fruit-prev btn btn-outline-primary'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 256 256' height='1.2em' fill='currentColor' class='align-middle pb-1'>
                        <polygon points='207.093,30.187 176.907,0 48.907,128 176.907,256 207.093,225.813 109.28,128'/>
                    </svg>
                </button>
                <button type='button' class='fruit-next btn btn-outline-primary'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 256 256' height='1.2em' fill='currentColor' class='align-middle pb-1'>
                        <polygon points='79.093,0 48.907,30.187 146.72,128 48.907,225.813 79.093,256 207.093,128'/>
                    </svg>
                </button>
            </div>
        </div>
        <div class='fruit d-none'>$new</div>
        
        <div class='d-flex justify-content-between px-1 pt-3'>
            <h4 class='pt-2'>".($lang == "ua" ? "Популярні" : "Popular")."</h4>
            <div class='pb-2'>
                <button type='button' class='popular-prev btn btn-outline-primary'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 256 256' height='1.2em' fill='currentColor' class='align-middle pb-1'>
                        <polygon points='207.093,30.187 176.907,0 48.907,128 176.907,256 207.093,225.813 109.28,128'/>
                    </svg>
                </button>
                <button type='button' class='popular-next btn btn-outline-primary'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 256 256' height='1.2em' fill='currentColor' class='align-middle pb-1'>
                        <polygon points='79.093,0 48.907,30.187 146.72,128 48.907,225.813 79.093,256 207.093,128'/>
                    </svg>
                </button>
            </div>
        </div>
        <div class='popular d-none'>$popular</div>
    </div>
</div>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script src='https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js'></script>
<script src='https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js'></script>
<script src='//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'></script>
<script src='$assets/js/main.js'></script>
<script src='$assets/js/slider.js'></script>
<script src='$assets/js/categories.js'></script>
<script src='$assets/js/search.js'></script>  
<script src='$assets/js/card.js'></script>
";

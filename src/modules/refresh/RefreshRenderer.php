<?php

include_once ROOT.'/modules/category/Category.php';
include_once ROOT.'/modules/category/CategoryRenderer.php';
include_once ROOT.'/modules/product/Product.php';
include_once ROOT.'/modules/product/ProductRenderer.php';

class RefreshRenderer
{
    public static function full()
    {
        $pages = [
            'name' => ['index', 'payment', 'blog', 'contact', 'about'],
            'ua' => ['Головна', 'Оплата і доставка', 'Блог', 'Контакти', 'Про нас'],
            'en' => ['Main', 'Payment and Delivery', 'Blog', 'Contacts', 'About Us']
        ];

        $cats = Utils::storage([
            'columns' => '*',
            'table' => '001_categories'
        ]);
        foreach ($cats as $i) {
            CategoryRenderer::details($i['id'], $pages);
        }

        $prods = Utils::storage([
            'columns' => 'id',
            'table' => '001_products'
        ]);
        foreach ($prods as $i) {
            ProductRenderer::details($i['id'], $pages);
        }

        $langs = ['ua', 'en'];
        foreach ($langs as $lang) {
            $menu = '';
            $menuMobile = '';
            foreach ($pages['name'] as $k => $name) {
                $title = $pages[$lang][$k];
                $menu .= "<li class='nav-item'><a class='nav-link text-secondary px-2 py-0' href='/$lang/$name.html'>$title</a></li>";
                $menuMobile .= "<a class='dropdown-item' href='/$lang/$name.html'>$title</a>";
            }

            self::main($lang, $menu, $menuMobile);
            self::payment($lang, $menu, $menuMobile);
            self::blog($lang, $menu, $menuMobile);
            self::contact($lang, $menu, $menuMobile);
            self::about($lang, $menu, $menuMobile);

            self::cart($lang, $menu, $menuMobile);
            self::checkout($lang, $menu, $menuMobile);
            self::cabinet($lang, $menu, $menuMobile);
        }

        Utils::generateSitemap();

        $r = 'Full refresh';
        return json_encode($r);
    }

    public static function cabinet($lang, $menu, $menuMobile)
    {
        switch ($lang) {
            case 'ua': $pageTitle = 'Кабінет | Вітамін+'; break;
            case 'en': $pageTitle = 'Cabinet | Vitamin+'; break;
        }
        $tagMetaDesc = '';

        $assets = '../assets';
        $dir = "/$lang";
        $page = 'cabinet';
        $pageUa = 'cabinet';
        $pageEn = 'cabinet';

        $details = include('cabinet.php');
        $header = include(ROOT.'/ssr/layout/header.php');
        $footer = include(ROOT.'/ssr/layout/footer.php');

        $content = $header . $details . $footer;
        $handle = fopen("$lang/cabinet.html",'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    public static function main($lang, $menu, $menuMobile)
    {
        switch ($lang) {
            case 'ua': $pageTitle = 'Головна | Вітамін+'; break;
            case 'en': $pageTitle = 'Main | Vitamin+'; break;
        }
        $tagMetaDesc = '';

        $assets = '../assets';
        $dir = "/$lang";
        $page = 'index';
        $pageUa = 'index';
        $pageEn = 'index';

        $new = Utils::storage([
            'columns' => '
                001_products.id,
                001_products.cat_id,
                001_products.price,
                001_products.vol,
                001_products.vol_min,
                001_product_'.$lang.'_details.title,
                001_product_'.$lang.'_details.slug,
                001_product_'.$lang.'_details.img,
                001_product_'.$lang.'_details.unit,
                001_category_'.$lang.'_details.title AS cat,
                001_category_'.$lang.'_details.slug AS cat_slug
            ',
            'table' => '001_products',
            'joins' => [
                [
                    'table' => '001_product_'.$lang.'_details',
                    'expresion' => '001_products.id = 001_product_'.$lang.'_details.prod_id'
                ],
                [
                    'table' => '001_category_'.$lang.'_details',
                    'expresion' => '001_products.cat_id = 001_category_'.$lang.'_details.cat_id',
                ]
            ],
            'conditions' => '001_products.visible = 1 LIMIT 20'
        ]);

        $popular = Utils::storage([
            'columns' => '
                001_product_'.$lang.'_details.title,
                001_product_'.$lang.'_details.slug,
                001_product_'.$lang.'_details.img,
                001_product_'.$lang.'_details.unit,
                001_products.id,
                001_products.price,
                001_products.vol,
                001_products.vol_min,
                cp.num
            ',
            'table' => '(SELECT product_id AS pid, COUNT(product_id) AS num FROM 001_cart_products GROUP BY pid) AS cp',
            'joins' => [
                [
                    'table' => '001_products',
                    'expresion' => '001_products.id = cp.pid'
                ],
                [
                    'table' => '001_product_'.$lang.'_details',
                    'expresion' => '001_product_'.$lang.'_details.prod_id = cp.pid'
                ]
            ],
            'conditions' => '001_products.visible = 1',
            'order' => 'cp.num DESC LIMIT 20'
        ]);

        $details = include('main.php');
        $header = include(ROOT . '/ssr/layout/header.php');
        $footer = include(ROOT . '/ssr/layout/footer.php');

        $content = $header . $details . $footer;
        $handle = fopen("$lang/index.html", 'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    public static function payment($lang, $menu, $menuMobile)
    {
        switch ($lang) {
            case 'ua': $pageTitle = 'Оплата і Доставка | Вітамін+'; break;
            case 'en': $pageTitle = 'Payment and Delivery | Vitamin+'; break;
        }
        $tagMetaDesc = '';

        $assets = '../assets';
        $dir = "/$lang";
        $page = 'payment';
        $pageUa = 'payment';
        $pageEn = 'payment';

        $details = include('payment.php');
        $header = include(ROOT.'/ssr/layout/header.php');
        $footer = include(ROOT.'/ssr/layout/footer.php');

        $content = $header . $details . $footer;
        $handle = fopen("$lang/payment.html",'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    public static function blog($lang, $menu, $menuMobile)
    {
        switch ($lang) {
            case 'ua': $pageTitle = 'Блог | Вітамін+'; break;
            case 'en': $pageTitle = 'Blog | Vitamin+'; break;
        }
        $tagMetaDesc = '';

        $assets = '../assets';
        $dir = "/$lang";
        $page = 'blog';
        $pageUa = 'blog';
        $pageEn = 'blog';

        $details = include('blog.php');
        $header = include(ROOT.'/ssr/layout/header.php');
        $footer = include(ROOT.'/ssr/layout/footer.php');

        $content = $header . $details . $footer;
        $handle = fopen("$lang/blog.html",'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    public static function contact($lang, $menu, $menuMobile)
    {
        switch ($lang) {
            case 'ua': $pageTitle = 'Контакти | Вітамін+'; break;
            case 'en': $pageTitle = 'Contacts | Vitamin+'; break;
        }
        $tagMetaDesc = '';

        $assets = '../assets';
        $dir = "/$lang";
        $page = 'contact';
        $pageUa = 'contact';
        $pageEn = 'contact';


        $details = include('contact.php');
        $header = include(ROOT.'/ssr/layout/header.php');
        $footer = include(ROOT.'/ssr/layout/footer.php');

        $content = $header . $details . $footer;
        $handle = fopen("$lang/contact.html",'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    public static function about($lang, $menu, $menuMobile)
    {
        switch ($lang) {
            case 'ua': $pageTitle = 'Про нас | Вітамін+'; break;
            case 'en': $pageTitle = 'About Us | Vitamin+'; break;
        }
        $tagMetaDesc = '';

        $assets = '../assets';
        $dir = "/$lang";
        $page = 'about';
        $pageUa = 'about';
        $pageEn = 'about';

        $details = include('about.php');
        $header = include(ROOT.'/ssr/layout/header.php');
        $footer = include(ROOT.'/ssr/layout/footer.php');

        $content = $header . $details . $footer;
        $handle = fopen("$lang/about.html",'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    public static function cart($lang, $menu, $menuMobile)
    {
        switch ($lang) {
            case 'ua': $pageTitle = 'Кошик | Вітамін+'; break;
            case 'en': $pageTitle = 'Cart | Vitamin+'; break;
        }
        $tagMetaDesc = '';

        $assets = '../assets';
        $dir = "/$lang";
        $page = 'cart';
        $pageUa = 'cart';
        $pageEn = 'cart';

        $details = include('cart.php');
        $header = include(ROOT.'/ssr/layout/header.php');
        $footer = include(ROOT.'/ssr/layout/footer.php');

        $content = $header . $details . $footer;
        $handle = fopen("$lang/cart.html",'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    public static function checkout($lang, $menu, $menuMobile)
    {
        switch ($lang) {
            case 'ua': $pageTitle = 'Перевірка | Вітамін+'; break;
            case 'en': $pageTitle = 'Checkout | Vitamin+'; break;
        }
        $tagMetaDesc = '';

        $assets = '../assets';
        $dir = "/$lang";
        $page = 'checkout';
        $pageUa = 'checkout';
        $pageEn = 'checkout';

        $details = include('checkout.php');
        $header = include(ROOT.'/ssr/layout/header.php');
        $footer = include(ROOT.'/ssr/layout/footer.php');

        $content = $header . $details . $footer;
        $handle = fopen("$lang/checkout.html",'w+');
        fwrite($handle, $content);
        fclose($handle);
    }
}

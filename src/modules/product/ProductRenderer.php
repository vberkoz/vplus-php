<?php

include_once 'Product.php';
include_once ROOT.'/modules/review/Review.php';

class ProductRenderer
{
    public static function details($id, $pages)
    {
        $langs = ['ua', 'en'];
        foreach ($langs as $lang) {
            $prods = Utils::storage([
                'columns' => '
                    001_products.id,
                    001_products.cat_id,
                    001_products.code,
                    001_products.def_img,
                    001_products.price,
                    001_products.visible,
                    001_products.vol,
                    001_products.vol_min,
                    001_product_'.$lang.'_details.title,
                    001_product_'.$lang.'_details.slug,
                    001_product_'.$lang.'_details.img,
                    001_product_'.$lang.'_details.desc,
                    001_product_'.$lang.'_details.char,
                    001_product_'.$lang.'_details.unit,
                    001_product_'.$lang.'_details.tag_title,
                    001_product_'.$lang.'_details.tag_meta_desc,
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
                'conditions' => "001_products.id = $id"
            ]);

            $prod = $prods[0];
            $pageTitle = $prod['tag_title'];
            $tagMetaDesc = $prod['tag_meta_desc'];
            $assets = '../../assets';
            $dir = "/$lang";

            $page = 'product/'.Utils::storage([
                'columns' => 'slug',
                'table' => '001_product_'.($lang == 'ua' ? 'en' : 'ua').'_details',
                'conditions' => "prod_id = $id"
            ])[0]['slug'];
            $pageUa = Utils::storage([
                'columns' => 'slug',
                'table' => '001_product_ua_details',
                'conditions' => "prod_id = $id"
            ])[0]['slug'];
            $pageEn = Utils::storage([
                'columns' => 'slug',
                'table' => '001_product_en_details',
                'conditions' => "prod_id = $id"
            ])[0]['slug'];

            $menu = '';
            $menuMobile = '';
            foreach ($pages['name'] as $k => $name) {
                $title = $pages[$lang][$k];
                $menu .= "<li class='nav-item'><a class='nav-link text-secondary px-2 py-0' href='/$lang/$name.html'>$title</a></li>";
                $menuMobile .= "<a class='dropdown-item' href='/$lang/$name.html'>$title</a>";
            }

            $desc = '';
            $descIndex = json_decode($prod['desc'], true);
            if ($descIndex) {
                foreach ($descIndex as $i) {
                    $desc .= "<p>$i</p>";
                }
            } else {
                if ($lang == 'ua') {
                    $desc .= "<div class='my-4'><h5 class='text-center'>Інформація відсутня</h5><p class='text-center'>Ми працюємо над вдосконаленням нашого сервісу.<br>Інформація про товар незабаром з'явиться.</p></div>";
                } else {
                    $desc .= "<div class='my-4'><h5 class='text-center'>No information available</h5><p class='text-center'>We are working to improve our service.<br>Product information will appear soon.</p></div>";
                }
            }
            $prod['desc'] = $desc;

            $char = '';
            $charIndex = json_decode($prod['char'], true);
            if ($charIndex) {
                $char .= "<ul>";
                foreach ($charIndex as $k => $i) {
                    $char .= "<li><strong>$k: </strong>$i</li>";
                }
                $char .= "</ul>";
            } else {
                if ($lang == 'ua') {
                    $char .= "<div class='my-4'><h5 class='text-center'>Характеристики відсутні</h5><p class='text-center'>Ми працюємо над вдосконаленням нашого сервісу.<br>Характеристики товару незабаром з'являться.</p></div>";
                } else {
                    $char .= "<div class='my-4'><h5 class='text-center'>No characteristics</h5><p class='text-center'>We are working to improve our service.<br>Product characteristics will appear soon.</p></div>";
                }
            }
            $prod['char'] = $char;

            $reviews = '';
            $reviewIndex = Review::index($id);
            if ($reviewIndex) {
                foreach ($reviewIndex as $i) {
                    $name = $i['name'];
                    $text = $i['text'];
                    $reviews .= "<p><strong>$name</strong><br>$text</p>";
                }
            } else {
                if ($lang == 'ua') {
                    $reviews .= "<div class='my-4'><h5 class='text-center'>Відгуків ще немає</h5><p class='text-center'>Поділіться своїми думками про цей товар</p></div>";
                } else {
                    $reviews .= "<div class='my-4'><h5 class='text-center'>There are no reviews yet</h5><p class='text-center'>Share your thoughts on this product</p></div>";
                }
            }

            $details = include('details.php');
            $header = include(ROOT . '/ssr/layout/header.php');
            $footer = include(ROOT . '/ssr/layout/footer.php');

            $content = $header . $details . $footer;
            $filename = $prod['slug'];
            $handle = fopen("$lang/product/$filename.html", 'w+');
            fwrite($handle, $content);
            fclose($handle);

            $file = "ssr/img/".$prod['def_img'];
            $newfile = "$lang/img/".$prod['img'];
            copy($file, $newfile);
        }

        Utils::generateSitemap();
    }
}

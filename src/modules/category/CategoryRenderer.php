<?php

include_once 'Category.php';
include_once ROOT.'/modules/product/Product.php';

class CategoryRenderer
{
    public static function details($cat_id, $pages)
    {
        $langs = ['ua', 'en'];
        foreach ($langs as $lang) {
            $prods = Utils::storage([
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
                'conditions' => "
                    001_products.cat_id = $cat_id AND 
                    001_products.visible = 1
                "
            ]);

            $cats = Utils::storage([
                'columns' => 'id, title, slug, tag_title, tag_meta_desc',
                'table' => '001_category_'.$lang.'_details',
                'conditions' => "id = $cat_id"
            ]);

            $pageTitle = $cats[0]['tag_title'];
            $tagMetaDesc = $cats[0]['tag_meta_desc'];
            $assets = '../../assets';
            $dir = "/$lang";
            $page = 'category/'.Utils::storage([
                'columns' => 'slug',
                'table' => '001_category_'.($lang == 'ua' ? 'en' : 'ua').'_details',
                'conditions' => "id = $cat_id"
            ])[0]['slug'];
            $pageUa = Utils::storage([
                'columns' => 'slug',
                'table' => '001_category_ua_details',
                'conditions' => "id = $cat_id"
            ])[0]['slug'];
            $pageEn = Utils::storage([
                'columns' => 'slug',
                'table' => '001_category_en_details',
                'conditions' => "id = $cat_id"
            ])[0]['slug'];


            $menu = '';
            $menuMobile = '';
            foreach ($pages['name'] as $k => $name) {
                $title = $pages[$lang][$k];
                $menu .= "<li class='nav-item'><a class='nav-link text-secondary px-2 py-0' href='/$lang/$name.html'>$title</a></li>";
                $menuMobile .= "<a class='dropdown-item' href='/$lang/$name.html'>$title</a>";
            }


            $details = include('details.php');
            $header = include(ROOT.'/ssr/layout/header.php');
            $footer = include(ROOT.'/ssr/layout/footer.php');

            $content = $header . $details . $footer;
            $filename = $cats[0]['slug'];
            $handle = fopen("$lang/category/$filename.html",'w+');
            fwrite($handle, $content);
            fclose($handle);
        }

        Utils::generateSitemap();
    }
}

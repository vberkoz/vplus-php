<?php

include_once 'Category.php';
include_once ROOT.'/modules/refresh/RefreshRenderer.php';

class CategoryService
{
    public static function index($lang)
    {
        return Utils::storage([
            'columns' => 'id, title, slug',
            'table' => '001_category_'.$lang.'_details'
        ]);
    }

    public static function list()
    {
        return Utils::storage([
            'columns' => '
                001_categories.id,
                001_categories.visible,
                001_category_ua_details.title AS title_ua,
                001_category_ua_details.slug AS slug_ua,
                001_category_ua_details.tag_title AS tag_title_ua,
                001_category_ua_details.tag_meta_desc AS tag_meta_desc_ua,
                001_category_en_details.title AS title_en,
                001_category_en_details.slug AS slug_en,
                001_category_en_details.tag_title AS tag_title_en,
                001_category_en_details.tag_meta_desc AS tag_meta_desc_en
            ',
            'table' => '001_categories',
            'joins' => [
                [
                    'table' => '001_category_ua_details',
                    'expresion' => '001_category_ua_details.cat_id = 001_categories.id'
                ],
                [
                    'table' => '001_category_en_details',
                    'expresion' => '001_category_en_details.cat_id = 001_categories.id'
                ],
            ]
        ]);
    }

    public static function update($data)
    {
        Category::updateAll($data);
        $pages = [
            'name' => ['index', 'payment', 'blog', 'contact', 'about'],
            'ua' => ['Головна', 'Оплата і доставка', 'Блог', 'Контакти', 'Про нас'],
            'en' => ['Main', 'Payment and Delivery', 'Blog', 'Contacts', 'About Us']
        ];
        foreach ($data as $i) {
            CategoryRenderer::details($i['id'], $pages);
        }
    }
}

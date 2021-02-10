<?php

include_once ROOT.'/modules/product/Product.php';

class SearchService
{
    public static function full($p)
    {
        $term = $p['term'];
        $lang = $p['lang'];
        $items = Utils::storage([
            'columns' => 'title, slug',
            'table' => '001_product_'.$lang.'_details',
            'joins' => [
                [
                    'table' => '001_products',
                    'expresion' => '001_products.id = 001_product_'.$lang.'_details.prod_id'
                ]
            ],
            'conditions' => "
                visible = 1
                AND title LIKE '%$term%' LIMIT 5
            "
        ]);
        foreach ($items as $k => $i) {
            $slug = $i['slug'];
            $items[$k]['link'] = "/$lang/product/$slug.html";
        }
        return $items;
    }
}

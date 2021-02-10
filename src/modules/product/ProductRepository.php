<?php


class ProductRepository
{
    public static function checkslug($data)
    {
        return Utils::storage([
            'columns' => 'prod_id',
            'table' => "001_product_" . $data['lang'] . "_details",
            'conditions' => "slug = '" . $data['slug'] . "'",
        ]);
    }
}

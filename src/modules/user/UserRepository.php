<?php

include_once ROOT.'/components/Utils.php';

class UserRepository
{
    public static function index()
    {
        return Utils::storage([
            'columns' => '*',
            'table' => '001_users',
            'conditions' => 'role = "client"'
        ]);
    }

    public static function products()
    {
        return Utils::storage([
            'columns' => '
                001_product_ua_details.title,
                001_products.price
            ',
            'table' => '001_products',
            'joins' => [
                [
                    'table' => '001_product_ua_details',
                    'expresion' => '001_product_ua_details.prod_id = 001_products.id'
                ]
            ]
        ]);
    }
}

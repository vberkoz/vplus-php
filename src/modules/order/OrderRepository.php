<?php

include_once ROOT.'/components/Utils.php';

class OrderRepository
{
    public static function index()
    {
        return Utils::storage([
            'columns' => '*',
            'table' => '001_carts',
            'conditions' => "created_at >= CONCAT(SUBDATE(CURDATE(), INTERVAL 1 DAY), ' 4:00:00')
                AND created_at < CONCAT(CURDATE(), ' 4:00:00')",
            'order' => 'created_at DESC'
        ]);
    }

    public static function products($orderId)
    {
        return Utils::storage([
            'columns' => '
                001_cart_products.cart_id,
                001_cart_products.product_id,
                001_cart_products.quantity,
                001_cart_products.price,
                001_product_ua_details.title,
                001_product_ua_details.unit
            ',
            'table' => '001_cart_products',
            'joins' => [
                [
                    'table' => '001_product_ua_details',
                    'expresion' => '001_product_ua_details.prod_id = 001_cart_products.product_id'
                ]
            ],
            'conditions' => '001_cart_products.cart_id = ' . $orderId
        ]);
    }
}

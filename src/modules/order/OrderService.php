<?php

include_once 'OrderRepository.php';

class OrderService
{
    public static function index()
    {
        return [
            'today' => self::orders('today'),
            'yesterday' => self::orders('yesterday'),
            'total' => self::orders('total')
        ];
    }

    private static function orders($period)
    {
        $products = [];
        $orders = OrderRepository::index($period);
        foreach ($orders as $key => $order) {
            $orders[$key]['products'] = OrderRepository::products($order['id']);
            foreach ($orders[$key]['products'] as $product) {
                $products[] = $product;
            }
        }
        $distinctProducts = [];
        $present = false;
        foreach ($products as $product) {
            foreach ($distinctProducts as $key => $distinctProduct) {
                if ($distinctProduct['product_id'] == $product['product_id']) {
                    $present = true;
                    $distinctProducts[$key]['quantity'] += $product['quantity'];
                    $distinctProducts[$key]['price'] = $product['price'] * $distinctProducts[$key]['quantity'];
                }
            }
            if (!$present) $distinctProducts[] = $product;
            $present = false;
        }
        return [
            'orders' => $orders,
            'distinctProducts' => $distinctProducts
        ];
    }
}

<?php


class CartProduct
{
    public static function insert($cartId, $items)
    {
        $db = Db::getConnection();
        $sql = '';
        foreach ($items as $i) {
            $productId = $i['id'];
            $quantity = $i['quantity'];
            $client = 0;
            $restaurant = 0;
            $price = $i['total'];
            $sql .= "INSERT INTO 001_cart_products (cart_id, product_id, quantity, client, restaurant, price) ".
                "VALUES ($cartId, $productId, $quantity, $client, $restaurant, $price); ";
        }
        $r = $db->prepare($sql);
        $r->execute();
    }
}

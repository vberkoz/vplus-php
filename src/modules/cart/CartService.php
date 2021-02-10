<?php

include_once 'Cart.php';
include_once 'CartRenderer.php';
include_once ROOT.'/components/Utils.php';
include_once ROOT.'/modules/product/Product.php';
include_once ROOT.'/modules/cart_product/CartProduct.php';
include_once ROOT.'/modules/user/UserService.php';

class CartService
{
    public static function copy($d)
    {
        $products = [];
        foreach ($d as $i) {
            $products[$i['id']] = $i['quantity'];
        }
        $_SESSION['products'] = $products;
        return $products;
    }

    public static function checkout($d, $lang)
    {
        $d['hash'] = Utils::hash();
        $d['user_id'] = UserService::logged();

        $summary = self::summary($lang);
        $d['count'] = $summary['count'];
        $d['price'] = $summary['price'];
        $d['discount'] = 0;

        $cartId = Cart::insert($d);
        $items = self::content($lang);
        CartProduct::insert($cartId, $items);

        $d['items'] = $items;
        $message = CartRenderer::mailTemplate($d);

        $email = 'vberkoz@gmail.com';
        $subject = 'Vitamin+ замовлення: ' . $cartId;
        $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($email, $subject, $message, $headers);
        unset($_SESSION['products']);

        return $d;
    }

    public static function summary($lang)
    {
        $items = self::content($lang);
        $price = 0;
        foreach ($items as $i) {
            $price += $i['total'];
        }

        $summary['count'] = self::countItems();
        $summary['price'] = $price;

        return $summary;
    }

    public static function content($lang)
    {
        $ids = self::index();
        $params = implode("','", array_keys($ids));
        $params = "'$params'";
        $products = Utils::storage([
            'columns' => '
                001_product_'.$lang.'_details.title,
                001_product_'.$lang.'_details.slug,
                001_product_'.$lang.'_details.img,
                001_product_'.$lang.'_details.unit,
                001_products.id,
                001_products.price,
                001_products.vol,
                001_products.vol_min
            ',
            'table' => '001_products',
            'joins' => [
                [
                    'table' => '001_product_'.$lang.'_details',
                    'expresion' => '001_products.id = 001_product_'.$lang.'_details.prod_id'
                ]
            ],
            'conditions' => "001_products.id IN ($params)"
        ]);
        foreach ($products as $k => $v) {
            foreach ($ids as $id => $q) {
                if ($products[$k]['id'] == $id) {
                    $products[$k]['quantity'] = $q;
                    $products[$k]['total'] = $q * $products[$k]['price'];
                }
            }
        }
        return $products;
    }

    public static function index()
    {
        if (isset($_SESSION['products'])) return $_SESSION['products'];
        return [];
    }

    public static function countItems()
    {
        if (isset($_SESSION['products'])) {
            return count($_SESSION['products']);
        } else {
            return 0;
        }
    }

    public static function update($id, $quantity)
    {
        $bag = [];
        if (isset($_SESSION['products'])) $bag = $_SESSION['products'];
        if ($quantity) {
            $bag[$id] = $quantity;
        } else {
            unset($bag[$id]);
        }
        $_SESSION['products'] = $bag;
        return self::countItems();
    }
}

<?php

include_once 'User.php';
include_once 'UserRepository.php';

class UserService
{
    public static function index()
    {
        return [
            'users' => UserRepository::index(),
            'products' => UserRepository::products()
        ];
    }

    public static function update($d)
    {
        return Utils::storage([
            'action' => 'update',
            'table' => '001_users',
            'set' => "username = '".$d['username']."', phone = '".$d['phone']."', address = '".$d['address']."'",
            'conditions' => 'id = '.self::logged(),
        ]);
    }

    public static function show()
    {
        return Utils::storage([
            'columns' => 'email, username, phone, address',
            'table' => '001_users',
            'conditions' => "id = ".self::logged(),
        ])[0];
    }

    public static function register($d)
    {
        $_SESSION['user'] = Utils::storage([
            'action' => 'insert',
            'columns' => 'username, email, secret, role',
            'table' => '001_users',
            'values' => "'".$d['name']."','".$d['email']."','".password_hash($d['secret'], PASSWORD_DEFAULT)."','client'"
        ]);
        return true;
    }

    public static function email($email)
    {
        return Utils::storage([
            'columns' => 'COUNT(*) AS found',
            'table' => '001_users',
            'conditions' => "email = '$email'"
        ])[0]['found'];
    }

    public static function orders($d)
    {
        $userId = $d['userId'];
        $lang = $d['lang'];
        $orders = Utils::storage([
            'columns' => "*",
            'table' => '001_carts',
            'conditions' => "user_id = '$userId'",
            'order' => 'created_at DESC'
        ]);
        foreach ($orders as $k => $i) {
            $cartId = $i['id'];
            $orders[$k]['products'] = Utils::storage([
                'columns' => '
                    001_cart_products.price,
                    001_cart_products.quantity,
                    001_product_'.$lang.'_details.title,
                    001_product_'.$lang.'_details.img,
                    001_product_'.$lang.'_details.unit,
                    001_products.vol,
                    001_products.id
                ',
                'table' => '001_cart_products',
                'joins' => [
                    [
                        'table' => '001_product_'.$lang.'_details',
                        'expresion' => '001_cart_products.product_id = 001_product_'.$lang.'_details.prod_id'
                    ],
                    [
                        'table' => '001_products',
                        'expresion' => '001_cart_products.product_id = 001_products.id'
                    ]
                ],
                'conditions' => "cart_id = '$cartId'"
            ]);
        }
        return $orders;
    }

    public static function logout()
    {
        unset($_SESSION['user']);
    }

    public static function login($d)
    {
        $email = $d['email'];
        $secret = $d['secret'];
        $users = Utils::storage([
            'columns' => 'id, secret',
            'table' => '001_users',
            'conditions' => "email = '$email'"
        ]);
        $user = $users[0];
        if (password_verify($secret, $user['secret'])) {
            $_SESSION['user'] = $user['id'];
            return $user['id'];
        }
        return false;
    }

    public static function logged()
    {
        if (isset($_SESSION['user'])) return $_SESSION['user'];
        return null;
    }
}

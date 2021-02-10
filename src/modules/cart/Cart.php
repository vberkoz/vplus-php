<?php


class Cart
{
    public static function insert($data)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO 001_carts (hash, user_id, name, phone, message, address, count, price, discount) 
                VALUES (:hash, :user_id, :name, :phone, :message, :address, :count, :price, :discount)';
        $r = $db->prepare($sql);
        $r->bindParam(':hash', $data['hash'], PDO::PARAM_STR);
        $r->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
        $r->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $r->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $r->bindParam(':message', $data['message'], PDO::PARAM_STR);
        $r->bindParam(':address', $data['address'], PDO::PARAM_STR);
        $r->bindParam(':count', $data['count'], PDO::PARAM_INT);
        $r->bindParam(':price', $data['price'], PDO::PARAM_STR);
        $r->bindParam(':discount', $data['discount'], PDO::PARAM_STR);
        $r->execute();
        return $db->lastInsertId();
    }
}

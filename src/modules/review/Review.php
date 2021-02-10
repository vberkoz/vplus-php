<?php

class Review
{
    public static function store(array $review): array
    {
        $dateTime = new DateTime();
        $date = $dateTime->format('Y-m-d H:i:s');

        $db = Db::getConnection();
        $sql = 'INSERT INTO 001_reviews (product_id, name, email, text, date)
                VALUES (:product_id, :name, :email, :text, :date)';

        $r = $db->prepare($sql);
        $r->bindParam(':product_id', $review['product_id'], PDO::PARAM_INT);
        $r->bindParam(':name', $review['name'], PDO::PARAM_STR);
        $r->bindParam(':email', $review['email'], PDO::PARAM_STR);
        $r->bindParam(':text', $review['text'], PDO::PARAM_STR);
        $r->bindParam(':date', $date, PDO::PARAM_STR);
        $r->execute();

        return self::index($review['product_id']);
    }

    public static function index(int $id): array
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM 001_reviews WHERE product_id = :product_id';

        $r = $db->prepare($sql);
        $r->bindParam(':product_id', $id, PDO::PARAM_INT);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetchAll();
    }
}

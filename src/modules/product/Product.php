<?php

include_once ROOT.'/components/Utils.php';

class Product
{
    public static function selectNew()
    {
        $db = Db::getConnection();
        $s = "
            SELECT 
                001_product_details.lang,
                001_product_details.title,
                001_product_details.slug,
                001_product_details.image,
                001_product_details.unit,
                001_products.id,
                001_products.category_id,
                001_products.price,
                001_products.volume,
                001_products.volume_min,
                001_categories.title AS category,
                001_categories.slug AS category_slug
            FROM 001_products
            LEFT JOIN 001_product_details ON 001_products.id = 001_product_details.product_id
            LEFT JOIN 001_categories ON 001_products.category_id = 001_categories.id
            WHERE 001_products.visible = 1 LIMIT 20";
        $r = $db->prepare($s);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetchAll();
    }

    public static function selectPopular()
    {
        $db = Db::getConnection();
        $s = "
            SELECT
                001_product_details.language,
                001_product_details.title,
                001_product_details.slug,
                001_product_details.image,
                001_product_details.unit,
                001_products.id,
                001_products.price,
                001_products.volume,
                001_products.volume_min,
                cp.num
            FROM (SELECT
                    product_id AS pid, 
                    COUNT(product_id) AS num
                FROM 001_cart_products
                GROUP BY pid) AS cp 
            LEFT JOIN 001_products ON 001_products.id = cp.pid
            LEFT JOIN 001_product_details ON 001_product_details.product_id = cp.pid
            ORDER BY cp.num DESC
            LIMIT 20";
        $r = $db->prepare($s);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetchAll();
    }

    public static function selectByTerm($term)
    {
        $db = Db::getConnection();
        $s = "SELECT title, slug FROM 001_product_details WHERE title LIKE '$term%' LIMIT 5";
        $r = $db->prepare($s);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetchAll();
    }

    public static function selectByIdForCart($ids)
    {
        $db = Db::getConnection();
        $sql = "
            SELECT 
                001_product_details.title,
                001_product_details.slug,
                001_product_details.image,
                001_product_details.unit,
                001_products.id,
                001_products.price,
                001_products.volume,
                001_products.volume_min
            FROM 001_products
            LEFT JOIN 001_product_details ON 001_products.id = 001_product_details.product_id
            WHERE 001_products.id IN ($ids)";
        $r = $db->prepare($sql);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetchAll();
    }

    public static function selectByCategory($category_id)
    {
        $db = Db::getConnection();
        $sql = "
            SELECT 
                001_product_details.language,
                001_product_details.title,
                001_product_details.slug,
                001_product_details.image,
                001_product_details.unit,
                001_products.id,
                001_products.category_id,
                001_products.price,
                001_products.volume,
                001_products.volume_min,
                001_categories.title AS category,
                001_categories.slug AS category_slug
            FROM 001_products
            LEFT JOIN 001_product_details ON 001_products.id = 001_product_details.product_id
            LEFT JOIN 001_categories ON 001_products.category_id = 001_categories.id
            WHERE 001_products.category_id = $category_id AND 001_products.visible = 1";
        $r = $db->prepare($sql);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetchAll();
    }

    public static function selectAll(): array
    {
        $db = Db::getConnection();
        $sql = "
            SELECT 
                001_products.id,
                001_products.visible,
                001_products.price,
                001_product_ua_details.title,
                001_category_ua_details.title AS category
            FROM 001_products
            LEFT JOIN 001_product_ua_details ON 001_products.id = 001_product_ua_details.prod_id
            LEFT JOIN 001_category_ua_details ON 001_products.cat_id = 001_category_ua_details.cat_id
            ORDER BY id DESC";
        $r = $db->prepare($sql);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetchAll();
    }

    public static function selectOne(int $id): array
    {
        $db = Db::getConnection();
        $sql = "
            SELECT 
                001_product_ua_details.title AS title_ua,
                001_product_ua_details.slug AS slug_ua,
                001_product_ua_details.img AS img_ua,
                001_product_ua_details.desc AS desc_ua,
                001_product_ua_details.char AS char_ua,
                001_product_ua_details.unit AS unit_ua,
                001_product_en_details.title AS title_en,
                001_product_en_details.slug AS slug_en,
                001_product_en_details.img AS img_en,
                001_product_en_details.desc AS desc_en,
                001_product_en_details.char AS char_en,
                001_product_en_details.unit AS unit_en,
                001_products.id,
                001_products.cat_id,
                001_products.code,
                001_products.price,
                001_products.visible,
                001_products.vol,
                001_products.vol_min,
                001_category_ua_details.title AS category,
                001_category_ua_details.slug AS category_slug
            FROM 001_products
            LEFT JOIN 001_product_ua_details ON 001_products.id = 001_product_ua_details.prod_id
            LEFT JOIN 001_product_en_details ON 001_products.id = 001_product_en_details.prod_id
            LEFT JOIN 001_category_ua_details ON 001_products.cat_id = 001_category_ua_details.cat_id
            WHERE 001_products.id = $id";
        $r = $db->prepare($sql);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetch();
    }

    public static function update(array $product)
    {
        $db = Db::getConnection();
        $id = $product['id'];
        $cat_id = $product['cat_id'];
        $code = $product['code'];
        $price = $product['price'];
        $visible = $product['visible'];
        $vol = $product['vol'];
        $vol_min = $product['vol_min'];

        $title_ua = $product['title_ua'];
        $slug_ua = $product['slug_ua'];
        $img_ua = $product['img_ua'];
        $desc_ua = $product['desc_ua'];
        $char_ua = $product['char_ua'];
        $unit_ua = $product['unit_ua'];

        $title_en = $product['title_en'];
        $slug_en = $product['slug_en'];
        $img_en = $product['img_en'];
        $desc_en = $product['desc_en'];
        $char_en = $product['char_en'];
        $unit_en = $product['unit_en'];

        $sql = "UPDATE `001_products`
                SET
                    `cat_id` = '$cat_id',
                    `code` = '$code',
                    `price` = '$price',
                    `visible` = '$visible',
                    `vol` = '$vol',
                    `vol_min` = '$vol_min'
                WHERE `id` = '$id';
                UPDATE `001_product_ua_details`
                SET
                    `title` = '$title_ua',
                    `slug` = '$slug_ua',
                    `img` = '$img_ua',
                    `desc` = '$desc_ua',
                    `char` = '$char_ua',
                    `unit` = '$unit_ua'
                WHERE `prod_id` = '$id';
                UPDATE `001_product_en_details`
                SET
                    `title` = '$title_en',
                    `slug` = '$slug_en',
                    `img` = '$img_en',
                    `desc` = '$desc_en',
                    `char` = '$char_en',
                    `unit` = '$unit_en'
                WHERE `prod_id` = '$id';";
        $r = $db->prepare($sql);
        $r->execute();

        return self::selectOne($id);
    }

    public static function insert(): array
    {
        $db = Db::getConnection();
        $hash = Utils::hash();
        $sql = "INSERT INTO 001_products (cat_id, code, def_img, price, visible, vol, vol_min)
                VALUES (1, '$hash', '$hash.jpg', 1, 0, 1, 0.1)";
        $r = $db->prepare($sql);
        $r->execute();

        $id = $db->lastInsertId();
        $sql = "INSERT INTO 001_product_ua_details (`prod_id`, `title`, `slug`, `img`, `desc`, `char`, `unit`)
                VALUES ($id, 'Новий товар $hash', 'novij-tovar-$hash', 'novij-tovar-$hash.jpg', '', '', 'кг');
                INSERT INTO 001_product_en_details (`prod_id`, `title`, `slug`, `img`, `desc`, `char`, `unit`)
                VALUES ($id, 'New product $hash', 'new-product-$hash', 'new-product-$hash.jpg', '', '', 'kg');";
        $r = $db->prepare($sql);
        $r->execute();

        copy("assets/images/no-image.jpg", "ssr/img/$hash.jpg");

        return self::selectOne($id);
    }

    public static function deleteSelected(string $ids): void
    {
        $db = Db::getConnection();
        $sql = "DELETE FROM 001_products WHERE id IN ($ids)";
        $r = $db->prepare($sql);
        $r->execute();
    }

}

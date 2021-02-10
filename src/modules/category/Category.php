<?php

include_once ROOT.'/components/Utils.php';

class Category
{
    public static function selectOne(int $id)
    {
        $db = Db::getConnection();
        $sql = "SELECT * FROM 001_categories WHERE id = $id";
        $r = $db->prepare($sql);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetch();
    }

    public static function selectAll(): array
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `001_category_ua_details`';
        $r = $db->prepare($sql);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetchAll();
    }

    public static function updateAll(array $categories): void
    {
        $db = Db::getConnection();
        $sql = '';
        foreach ($categories as $item) {
            $id = $item['id'];
            $title_ua = $item['title_ua'];
            $slug_ua = $item['slug_ua'];
            $tag_title_ua = $item['tag_title_ua'];
            $tag_meta_desc_ua = $item['tag_meta_desc_ua'];

            $title_en = $item['title_en'];
            $slug_en = $item['slug_en'];
            $tag_title_en = $item['tag_title_en'];
            $tag_meta_desc_en = $item['tag_meta_desc_en'];
            $visible = $item['visible'];
            $sql .= "
                UPDATE `001_category_ua_details` 
                SET title = '$title_ua', slug = '$slug_ua', tag_title = '$tag_title_ua', tag_meta_desc = '$tag_meta_desc_ua'
                WHERE cat_id = $id;
                UPDATE `001_category_en_details` 
                SET title = '$title_en', slug = '$slug_en', tag_title = '$tag_title_en', tag_meta_desc = '$tag_meta_desc_en'
                WHERE cat_id = $id;
                UPDATE `001_categories` 
                SET visible = $visible
                WHERE id = $id;
            ";
        }

        $r = $db->prepare($sql);
        $r->execute();
    }

    public static function insert(): array
    {
        $db = Db::getConnection();
        $hash = Utils::hash();
        $sql = "
            INSERT INTO 001_categories (visible)
            VALUES (0);
        ";
        $r = $db->prepare($sql);
        $r->execute();
        $id = $db->lastInsertId();

        $sql = "
            INSERT INTO 001_category_ua_details (cat_id, title, slug)
            VALUES ($id, '$hash', '$hash');
            INSERT INTO 001_category_en_details (cat_id, title, slug)
            VALUES ($id, '$hash', '$hash');
        ";
        $r = $db->prepare($sql);
        $r->execute();


        $sql = "
            SELECT
                001_categories.id,
                001_categories.visible,
                001_category_ua_details.title AS title_ua,
                001_category_ua_details.slug AS slug_ua,
                001_category_en_details.title AS title_en,
                001_category_en_details.slug AS slug_en
            FROM `001_categories`
            LEFT JOIN 001_category_ua_details
            ON 001_category_ua_details.cat_id = 001_categories.id
            LEFT JOIN 001_category_en_details
            ON 001_category_en_details.cat_id = 001_categories.id
            WHERE 001_categories.id = $id
        ";
        $r = $db->prepare($sql);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetch();
    }

    public static function deleteSelected(string $ids): void
    {
        $db = Db::getConnection();
        $sql = "DELETE FROM 001_categories WHERE id IN ($ids)";
        $r = $db->prepare($sql);
        $r->execute();
    }
}

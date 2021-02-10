<?php


class Utils
{
    private static function generateXmlElement($ua, $en, $entity)
    {
//        return '
//        <url>
//            <loc>https://vplus.in.ua/ua/' . $entity . $ua . '.html</loc>
//            <xhtml:link
//               rel="alternate"
//               hreflang="en-UA"
//               href="https://vplus.in.ua/en/' . $entity . $en . '.html"/>
//            <lastmod>' . date("Y-m-d") . '</lastmod>
//        </url>';
        return '
        <url>
            <loc>https://vplus.in.ua/ua/' . $entity . $ua . '.html</loc>
            <lastmod>' . date("Y-m-d") . '</lastmod>
        </url>
        <url>
            <loc>https://vplus.in.ua/en/' . $entity . $en . '.html</loc>
            <lastmod>' . date("Y-m-d") . '</lastmod>
        </url>';
    }

    public static function generateSitemap()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
        $content .= self::generateXmlElement('about', 'about', '');
        $content .= self::generateXmlElement('blog', 'blog', '');
        $content .= self::generateXmlElement('contact', 'contact', '');
        $content .= self::generateXmlElement('index', 'index', '');
        $content .= self::generateXmlElement('payment', 'payment', '');

        $cats = self::storage([
            'columns' => '001_category_ua_details.slug AS slug_ua, 001_category_en_details.slug AS slug_en',
            'table' => '001_category_ua_details',
            'joins' => [
                [
                    'table' => '001_category_en_details',
                    'expresion' => '001_category_ua_details.cat_id = 001_category_en_details.cat_id'
                ],
                [
                    'table' => '001_categories',
                    'expresion' => '001_category_ua_details.cat_id = 001_categories.id'
                ]
            ],
            'conditions' => '001_categories.visible = 1'
        ]);

        foreach ($cats as $cat) {
            $content .= self::generateXmlElement($cat['slug_ua'], $cat['slug_en'], 'category/');
        }

        $prods = self::storage([
            'columns' => '001_product_ua_details.slug AS slug_ua, 001_product_en_details.slug AS slug_en',
            'table' => '001_product_ua_details',
            'joins' => [
                [
                    'table' => '001_product_en_details',
                    'expresion' => '001_product_ua_details.prod_id = 001_product_en_details.prod_id'
                ],
                [
                    'table' => '001_products',
                    'expresion' => '001_product_ua_details.prod_id = 001_products.id'
                ]
            ],
            'conditions' => '001_products.visible = 1'
        ]);

        foreach ($prods as $prod) {
            $content .= self::generateXmlElement($prod['slug_ua'], $prod['slug_en'], 'product/');
        }

        $content .= '
</urlset>';
        $handle = fopen("sitemap.xml",'w+');
        fwrite($handle, $content);
        fclose($handle);
    }

    public static function generateDefaultImages()
    {
        $prods = self::storage([
            'columns' => '*',
            'table' => 'old_products'
        ]);
        $res = [];
        $s = '';
        foreach ($prods as $i) {
            $img = $i['def_img'];
            $code = self::hash();
            $file = "ssr/img1/$img";
            $newfile = "ssr/img/$code.jpg";

            if (!copy($file, $newfile)) {
                $res[] = "Unable to copy: $img";
            } else {
                $res[] = "Copied: $code.jpg";
            }

            $s .= "UPDATE old_products SET code = '$code', def_img = '$code.jpg' WHERE id = ".$i['id'].";";
        }
        $db = Db::getConnection();
        $r = $db->prepare($s);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $res;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function slug()
    {
        $products = self::storage([
            'columns' => 'id, title',
            'table' => 'product_ua_details'
        ]);

        $sql = "";
        foreach ($products as $item) {
            $id = $item['id'];
            $slug = self::url_slug($item['title'], ['transliterate' => true]);
            $sql .= "UPDATE product_ua_details SET slug = '$slug', img = '$slug.jpg' WHERE id = $id;";
        }
        $db = Db::getConnection();
        $r = $db->prepare($sql);
        $r->execute();

        print_r($sql);
        return true;
    }

    public static function url_slug($str, $options = array()) {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    public static function hash()
    {
        return sprintf( '%04x%04x%04x',
            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public static function storage(array $p)
    {
        if (isset($p['columns'])) $columns = $p['columns'];
        $table = $p['table'];

        $joins = '';
        if (isset($p['joins'])) {
            foreach ($p['joins'] as $i) {
                $joinTable = $i['table'];
                $joinExpresion = $i['expresion'];
                $joins .= " LEFT JOIN $joinTable ON $joinExpresion";
            }
        }

        $conditions = '';
        if (isset($p['conditions'])) $conditions = "WHERE " . $p['conditions'];

        $order = '';
        if (isset($p['order'])) $order = "ORDER BY " . $p['order'];

        if (!isset($p['action'])) $s = "SELECT $columns FROM $table $joins $conditions $order";

        if (isset($p['action']) && $p['action'] == 'insert') {
            $values = $p['values'];
            $s = "INSERT INTO $table ($columns) VALUES ($values)";
        }

        if (isset($p['action']) && $p['action'] == 'update') {
            $set = $p['set'];
            $s = "UPDATE $table SET $set $conditions";
        }
//        return $s;
//        echo $s;

        $db = Db::getConnection();
        $r = $db->prepare($s);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        if (!isset($p['action'])) return $r->fetchAll();
        return $db->lastInsertId();
    }

    public static function copyImages()
    {
        $files = self::storage([
            'columns' => 'product_ua_details.img AS img_ua, product_en_details.img AS img_en',
            'table' => 'product_ua_details',
            'joins' => [
                [
                    'table' => 'product_en_details',
                    'expresion' => 'product_ua_details.prod_id = product_en_details.prod_id'
                ]
            ]
        ]);
        $r = [];
        foreach ($files as $i) {
            $img_ua = $i['img_ua'];
            $img_en = $i['img_en'];
            $file = "public/ua/img/$img_ua";
            $newfile = "public/en/img/$img_en";

            if (!copy($file, $newfile)) {
                $r[] = "Unable to copy: $img_ua";
            } else {
                $r[] = "Copied: $img_en";
            }
        }

        return $r;
    }

//    Copy 'ua' rows and prepend 'en' in product_details
//
//    SELECT
//    product_id,
//    REPLACE(lang, 'ua', 'en') AS lang,
//    CONCAT('en ', title) AS title,
//    CONCAT('en-', slug) AS slug,
//    CONCAT('en-', image) AS image,
//    CONCAT('en-', description) AS description,
//    CONCAT('en-', characteristics) AS characteristics,
//    REPLACE(REPLACE(unit, 'кг', 'kg'), 'шт', 'pcs') AS unit
//    FROM product_details
//    WHERE product_id IN (SELECT id FROM products)
}

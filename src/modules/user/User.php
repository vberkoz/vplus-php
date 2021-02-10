<?php


class User
{
    public static function one(array $p): array
    {
        $columns = $p['columns'];
        $table = $p['table'];
        $conditions = $p['conditions'];
        $s = "SELECT $columns FROM $table WHERE $conditions";

        $db = Db::getConnection();
        $r = $db->prepare($s);
        $r->setFetchMode(PDO::FETCH_ASSOC);
        $r->execute();
        return $r->fetch();
    }
}

<?php

namespace app\Models;


use Core\Model;

class Post extends Model
{

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll(){
        $db = static::getDB();

        $query = $db->query('SELECT id, title, content FROM posts ORDER BY created_at');

        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

}
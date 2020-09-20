<?php

class DB
{
    // Объект Mysqli
    private static $mysqli = null;

    /**
     * Получение соединения к бд
     * @return bool|mysqli|null
     */
    public static function getConnection ()
    {
        if (self::$mysqli == null) {
            self::$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if (self::$mysqli == false) {
                echo 'Ошибка: Невозможно подключиться к MySQL ' . self::$mysqli->connect_error;
                return false;
            }
        }
        return self::$mysqli;
    }

    /**
     * Получение альбомов
     * @return bool|mysqli_result|null
     */
    public static function getAlbums()
    {
        $res = null;
        $db = self::getConnection();
        $sql = 'SELECT * FROM albums ORDER BY id ASC LIMIT ' . PAGER_LIMIT;
        $res = $db->query($sql);
        return $res;
    }

    /**
     * Получение фотографий
     * @return array|mixed
     */
    public static function getImages()
    {
        $rows = [];
        $db = self::getConnection();
        $sql = 'SELECT * FROM albums LEFT JOIN images ON albums.id = images.albums_id';
        $res = $db->query($sql);
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

}
<?php

namespace App\Helpers;

class DB
{
    private static $conn;

    public static function getConnection()
    {
        if (!self::$conn) {
            self::$conn = new \mysqli("db", "user", "user_password", "course_platform");

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }

        return self::$conn;
    }
}

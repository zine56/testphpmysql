<?php

namespace App\Helpers;

use mysqli;


class DB
{
    private static $conn;

    public static function getConnection()
    {
        if (!self::$conn) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            self::$conn = new \mysqli("db", "user", "user_password", "course_platform");

            if (self::$conn->connect_error) {
                throw new \Exception('Connection failed: ' . self::$connection->connect_error);
            }
        }

        return self::$conn;
    }
}

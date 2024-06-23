<?php

namespace App\Models;

use App\Helpers\DB;
use mysqli_sql_exception;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    public static function create($data)
    {
        $conn = DB::getConnection();
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $data['name'], $data['email'], $data['password']);
        try {
            $stmt->execute();
            return $conn->insert_id;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // Duplicate entry
                return ['error' => 'Email ya existe.'];
            }
            throw $e;
        }
    }

    public static function where($field, $value)
    {
        $conn = DB::getConnection();
        $sql = "SELECT * FROM users WHERE $field = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_object(__CLASS__);
        } else {
            return null;
        }
    }

    public static function find($id)
    {
        return self::where('id', $id);
    }
}

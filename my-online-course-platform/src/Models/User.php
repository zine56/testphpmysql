<?php

namespace App\Models;

use App\Helpers\DB;

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
        $stmt->execute();
        return $conn->insert_id;
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

<?php

namespace App\Models;

use App\Helpers\DB;

class Course
{
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $status;
    public $created_at;

    public static function create($data)
    {
        $conn = DB::getConnection();
        $sql = "INSERT INTO courses (user_id, title, description, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $data['user_id'], $data['title'], $data['description'], $data['status']);
        $stmt->execute();
        return $conn->insert_id;
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $result = $conn->query("SELECT * FROM courses");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $sql = "SELECT * FROM courses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_object(__CLASS__);
        } else {
            return null;
        }
    }

    public function save()
    {
        $conn = DB::getConnection();
        $sql = "UPDATE courses SET title = ?, description = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $this->title, $this->description, $this->status, $this->id);
        $stmt->execute();
    }

    public function delete()
    {
        $conn = DB::getConnection();
        $sql = "DELETE FROM courses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }
}

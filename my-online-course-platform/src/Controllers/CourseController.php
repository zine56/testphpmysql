<?php

namespace App\Controllers;

use App\Models\Course;
use App\Helpers\DB;
use App\Helpers\View;

class CourseController
{
    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public function index()
    {
        $courses = Course::all();
        View::render('courses/index.twig', ['courses' => $courses]);
    }

    public function store()
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $user_id = $_SESSION['user_id'];

        Course::create([
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'user_id' => $user_id
        ]);

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Curso creado con éxito']);
    }

    public function show($vars)
    {
        $id = $vars['id'];
        $course = Course::find($id);

        header('Content-Type: application/json');
        echo json_encode($course);
    }

    public function edit($id)
    {
        $course = Course::find($id);
        View::render('courses/edit.twig', ['course' => $course]);
    }

    public function update($id)
    {
        $course = Course::find($id);

        $course->title = $_POST['title'];
        $course->description = $_POST['description'];
        $course->status = $_POST['status'];
        $course->save();

        header('Location: /courses/' . $id);
    }

    public function destroy($vars)
    {
        $id = $vars['id'];
        $course = Course::find($id);

        if (!$course) {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['message' => 'Curso no encontrado']);
            exit();
        }

        if ($course->user_id != $_SESSION['user_id']) {
            header('HTTP/1.0 403 Forbidden');
            echo json_encode(['message' => 'No tienes permiso para eliminar este curso']);
            exit();
        }
        error_log("Deleting course ID: " . $course->id);

        $course->delete();

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Curso eliminado con éxito']);
    }
}

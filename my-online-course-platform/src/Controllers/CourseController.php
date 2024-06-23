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
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'status' => $status
        ]);

        header('Location: /courses');
    }

    public function show($id)
    {
        $course = Course::find($id);
        View::render('courses/view.twig', ['course' => $course]);
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

    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();
        header('Location: /courses');
    }
}

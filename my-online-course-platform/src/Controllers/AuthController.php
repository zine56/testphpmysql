<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\DB;
use App\Helpers\View;

class AuthController
{
    public function showLoginForm()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: /courses');
            exit();
        }
        View::render('auth/login.twig');
    }

    public function login()
    {
        session_start();
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::where('email', $email);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            header('Location: /courses');
        } else {
            View::render('auth/login.twig', ['error' => 'Invalid email or password']);
        }
    }

    public function showRegisterForm()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: /courses');
            exit();
        }
        View::render('auth/register.twig');
    }

    public function register()
    {
        session_start();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $user_id = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $_SESSION['user_id'] = $user_id;
        header('Location: /courses');
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
    }
}

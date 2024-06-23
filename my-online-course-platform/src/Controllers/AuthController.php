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
            $_SESSION['user_name'] = $user->name; // Guardar el nombre del usuario en la sesión
            header('Location: /courses');
        } else {
            View::render('auth/login.twig', ['error' => 'Email o Password Invalido']);
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
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
            View::render('auth/register.twig', [
                'error' => 'Por favor, complete todos los campos.'
            ]);
            return;
        }
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $result = User::create($data);


        if (isset($result['error'])) {
            View::render('auth/register.twig', [
                'error' => $result['error']
            ]);
            return;
        }

        session_start();

        $_SESSION['user_id'] = $result;
        $_SESSION['user_name'] = $data['name']; // Guardar el nombre del usuario en la sesión

        header('Location: /courses');
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
    }
}

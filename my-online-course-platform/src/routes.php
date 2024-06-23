<?php

use App\Controllers\AuthController;
use App\Controllers\CourseController;

return function (FastRoute\RouteCollector $r) {
    // Rutas de autenticación
    $r->addRoute('GET', '/login', [AuthController::class, 'showLoginForm']);
    $r->addRoute('POST', '/login', [AuthController::class, 'login']);
    $r->addRoute('GET', '/register', [AuthController::class, 'showRegisterForm']);
    $r->addRoute('POST', '/register', [AuthController::class, 'register']);
    $r->addRoute('GET', '/logout', [AuthController::class, 'logout']);

    // Rutas de gestión de cursos (protegidas)
    $r->addRoute('GET', '/courses', [CourseController::class, 'index']);
    $r->addRoute('GET', '/courses/create', [CourseController::class, 'create']);
    $r->addRoute('POST', '/courses', [CourseController::class, 'store']);
    $r->addRoute('GET', '/courses/{id:\d+}', [CourseController::class, 'show']);
    $r->addRoute('GET', '/courses/{id:\d+}/edit', [CourseController::class, 'edit']);
    $r->addRoute('POST', '/courses/{id:\d+}', [CourseController::class, 'update']);
    $r->addRoute('POST', '/courses/{id:\d+}/delete', [CourseController::class, 'destroy']);

};

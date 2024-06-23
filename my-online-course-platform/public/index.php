<?php

require '../vendor/autoload.php';

use FastRoute\RouteCollector;

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    // Rutas de autenticación
    $r->addRoute('GET', '/login', [\App\Controllers\AuthController::class, 'showLoginForm']);
    $r->addRoute('POST', '/login', [\App\Controllers\AuthController::class, 'login']);
    $r->addRoute('GET', '/register', [\App\Controllers\AuthController::class, 'showRegisterForm']);
    $r->addRoute('POST', '/register', [\App\Controllers\AuthController::class, 'register']);
    $r->addRoute('GET', '/logout', [\App\Controllers\AuthController::class, 'logout']);

    // Rutas de gestión de cursos (protegidas)
    $r->addRoute('GET', '/courses', [\App\Controllers\CourseController::class, 'index']);
    $r->addRoute('GET', '/courses/create', [\App\Controllers\CourseController::class, 'create']);
    $r->addRoute('POST', '/courses', [\App\Controllers\CourseController::class, 'store']);
    $r->addRoute('GET', '/courses/{id:\d+}', [\App\Controllers\CourseController::class, 'show']);
    $r->addRoute('GET', '/courses/{id:\d+}/edit', [\App\Controllers\CourseController::class, 'edit']);
    $r->addRoute('POST', '/courses/{id:\d+}', [\App\Controllers\CourseController::class, 'update']);
    $r->addRoute('POST', '/courses/{id:\d+}/delete', [\App\Controllers\CourseController::class, 'destroy']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Redirigir la ruta base a la página de login
if ($uri === '/') {
    header('Location: /login');
    exit();
}

// Eliminar la cadena de consulta (?foo=bar) si existe
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
// Decodificar URI
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;
        (new $controller)->$method($vars);
        break;
}

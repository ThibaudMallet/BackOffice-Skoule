<?php

require_once '../vendor/autoload.php';

session_start();
// Mise en place des routes

$router = new AltoRouter();

if (array_key_exists('BASE_URI', $_SERVER)) {
    // On définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
} else { 
    // Sinon on donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

/* HOME */ 
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);

/* TEACHERS LIST */ 
$router->map(
    'GET',
    '/teachers',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-list'
);

/* TEACHERS ADD */ 
$router->map(
    'GET',
    '/teachers/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-add'
);

$router->map(
    'POST',
    '/teachers/add',
    [
        'method' => 'insert',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-insert'
);

/* STUDENTS LIST */ 
$router->map(
    'GET',
    '/students',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-list'
);

/* STUDENTS ADD */ 
$router->map(
    'GET',
    '/students/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-add'
);

$router->map(
    'POST',
    '/students/add',
    [
        'method' => 'insert',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-insert'
);

/* SIGN IN PAGE */ 
$router->map(
    'GET',
    '/signin',
    [
        'method' => 'loginForm',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-loginform'
);

$router->map(
    'POST',
    '/signin',
    [
        'method' => 'connect',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-connect'
);

/* SIGN IN PAGE */
$router->map(
    'GET', 
    '/logout',
    [
        "method" => "logout",
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-logout'
);


// Distpatch

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

// On passe des variable au constructeur de nos controllers
$dispatcher->setControllersArguments($match['name'], $router);

// Si j'altère la valeur de $routeur, c'est pas grave j'ai fait les choses bien,
// Il est stocké en propriété dans mon controlleur
$router = null;

// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
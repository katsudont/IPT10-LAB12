<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "vendor/autoload.php";
require "init.php";

// Database connection object (from init.php (DatabaseConnection))
global $conn;

try {

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Define routes
    $router->get('/', function() {
        session_destroy();
        echo 'Exam Registration <a href="/register">Click Here</a>';
    });

    $router->get('/register', '\App\Controllers\ExamController@registrationForm');
    $router->post('/register', '\App\Controllers\ExamController@register');
    $router->get('/exam', '\App\Controllers\ExamController@exam');
    $router->post('/exam', '\App\Controllers\ExamController@exam');
    $router->get('/result', '\App\Controllers\ExamController@result');

    // Run it!
    $router->run();

} catch (Exception $e) {

    echo json_encode([
        'error' => $e->getMessage()
    ]);

}

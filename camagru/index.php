<?php

require_once 'src/controllers/database.php';


$controller = 'login';
$action = 'index';

if (isset($_GET['page'])) {
    $controller = $_GET['page'];
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

require_once "src/controllers/$controller.php";

$controllerClass = ucfirst($controller) . 'Controller';
if (file_exists("src/controllers/$controller.php")) {
    $controllerInstance = new $controllerClass();
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        echo "Invalid action";
    }
} else {
    echo "Page not found";
}

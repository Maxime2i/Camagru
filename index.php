<?php

// Routeur pour gérer les différentes requêtes

echo "Hello World!";
echo "Hello World!";

// Inclusion du modèle
require_once 'app/models/Model.php';
require_once 'config/setup.php';

require_once 'info.php';
echo "Hello World!";
// Contrôleur par défaut
$controller = 'login';
$action = 'index';

// Vérification de l'existence d'un contrôleur spécifié dans l'URL
if (isset($_GET['page'])) {
    $controller = $_GET['page'];
}
echo "Hello World!";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

// Inclusion du contrôleur approprié
require_once "app/controllers/$controller.php";

// Instanciation du contrôleur
$controllerClass = ucfirst($controller) . 'Controller';
echo "Hello World!";
// Vérification de l'existence du fichier contrôleur
if (file_exists("app/controllers/$controller.php")) {
    // Instanciation du contrôleur
    $controllerInstance = new $controllerClass();
    echo "Hello World!";
    if (method_exists($controllerInstance, $action)) {
        // Appel de la méthode spécifiée dans le contrôleur
        $controllerInstance->$action();
    } else {
        // Action non valide pour cette page
        echo "Invalid action";
    }
} else {
    // Page non trouvée
    echo "Page not found";
}

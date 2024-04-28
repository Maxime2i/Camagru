<?php

// Routeur pour gérer les différentes requêtes


// Inclusion du modèle
require_once 'src/models/Model.php';
//require_once 'config/setup.php';


// Contrôleur par défaut
$controller = 'login';
$action = 'index';

// Vérification de l'existence d'un contrôleur spécifié dans l'URL
if (isset($_GET['page'])) {
    $controller = $_GET['page'];
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

// Inclusion du contrôleur approprié
require_once "src/controllers/$controller.php";

// Instanciation du contrôleur
$controllerClass = ucfirst($controller) . 'Controller';
// Vérification de l'existence du fichier contrôleur
if (file_exists("src/controllers/$controller.php")) {
    // Instanciation du contrôleur
    $controllerInstance = new $controllerClass();
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

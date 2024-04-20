<?php

// Routeur pour gérer les différentes requêtes

// Inclusion du modèle
require_once 'app/models/Model.php';

// Contrôleur par défaut
$controller = 'login';

// Vérification de l'existence d'un contrôleur spécifié dans l'URL
if (isset($_GET['page'])) {
    $controller = $_GET['page'];
}

// Inclusion du contrôleur approprié
require_once "app/controllers/$controller.php";

// Instanciation du contrôleur
$controllerClass = ucfirst($controller) . 'Controller';

// Vérification de l'existence du fichier contrôleur
if (file_exists("app/controllers/$controller.php")) {
    // Instanciation du contrôleur
    $controllerInstance = new $controllerClass();

    // Exécution de l'action appropriée
    $controllerInstance->handleRequest();
} else {
    // Page non trouvée
    echo "Page not found";
}
?>

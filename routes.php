<?php
require_once 'vendor/autoload.php'; // Assurez-vous que ce chemin est correct

// Créer une instance d'AltoRouter
$router = new AltoRouter();

// Définir les routes
$routes = [
    // Routes pour l'authentification
    ['GET', '/', ['AuthController', 'login']],
    ['GET', '/register', ['AuthController', 'register']],
    ['POST', '/login', ['AuthController', 'loginPost']],
    ['POST', '/register', ['AuthController', 'registerPost']],
    ['GET', '/logout', ['AuthController', 'logout']], // Route pour la déconnexion

    // Routes pour les étudiants
    ['GET', '/etudiant/offres', ['EtudiantController', 'viewOffers']],
    ['GET', '/etudiant/profil', ['EtudiantController', 'viewProfile']],
    ['POST', '/etudiant/candidature', ['EtudiantController', 'applyForOffer']],
    ['GET', '/etudiant/candidature/{id}', ['EtudiantController', 'viewApplication']], // Pour voir une candidature spécifique

    // Routes pour les tuteurs
    ['GET', '/tuteur/profil-stagiaire', ['TuteurController', 'viewStudentProfile']],
    ['POST', '/tuteur/solliciter', ['TuteurController', 'solicitIntern']],
    ['GET', '/tuteur/candidatures-validees', ['TuteurController', 'viewValidatedApplications']],
    ['GET', '/tuteur/candidatures-rejetees', ['TuteurController', 'viewRejectedApplications']], // Pour voir les candidatures rejetées

    // Routes pour les responsables de stage
    ['GET', '/responsable-stage/gestion-offres', ['ResponsableStageController', 'manageOffers']],
    ['POST', '/responsable-stage/valider-candidature', ['ResponsableStageController', 'validateApplication']],
    ['POST', '/responsable-stage/rejeter-candidature', ['ResponsableStageController', 'rejectApplication']],
    ['GET', '/responsable-stage/candidatures-validees', ['ResponsableStageController', 'viewValidatedApplications']],
    ['GET', '/responsable-stage/candidatures-rejetees', ['ResponsableStageController', 'viewRejectedApplications']],
    ['GET', '/responsable-stage/offres-publiees', ['ResponsableStageController', 'viewPublishedOffers']],

    // Routes pour l'administrateur
    ['GET', '/admin/gestion-utilisateurs', ['AdminController', 'manageUsers']],
    ['POST', '/admin/ajouter-utilisateur', ['AdminController', 'addUser']],
    ['POST', '/admin/retirer-utilisateur', ['AdminController', 'removeUser']],
    ['GET', '/admin/afficher-utilisateur/{id}', ['AdminController', 'viewUser']], // Pour afficher un utilisateur spécifique
];

// Ajouter les routes au routeur
foreach ($routes as $route) {
    $router->addRoute($route[0], $route[1], $route[2]);
}

// Optionnel : Pour obtenir les paramètres de la requête et le nom de la route correspondante
$match = $router->match();
if ($match) {
    list($controller, $action) = $match['target'];
    $params = $match['params'];

    // Instancier le contrôleur et appeler la méthode correspondante
    if (class_exists($controller) && method_exists($controller, $action)) {
        $controllerInstance = new $controller();
        call_user_func_array([$controllerInstance, $action], $params);
    } else {
        // Gestion des erreurs si le contrôleur ou la méthode n'existe pas
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        echo "404 Not Found";
    }
} else {
    // Gestion des erreurs si aucune route ne correspond
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo "404 Not Found";
}

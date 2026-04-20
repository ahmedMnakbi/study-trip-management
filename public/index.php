<?php

declare(strict_types=1);

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

$routes = [
    'home' => [HomeController::class, 'index'],

    'login' => [AuthController::class, 'login'],
    'login/store' => [AuthController::class, 'authenticate'],
    'register' => [AuthController::class, 'register'],
    'register/store' => [AuthController::class, 'storeRegister'],
    'logout' => [AuthController::class, 'logout'],

    'voyages' => [VoyageController::class, 'index'],
    'voyage/show' => [VoyageController::class, 'show'],

    'mes-inscriptions' => [InscriptionController::class, 'mine'],
    'inscription/store' => [InscriptionController::class, 'store'],
    'inscription/status' => [InscriptionController::class, 'updateStatus'],
    'documents' => [DocumentController::class, 'mine'],
    'document/upload' => [DocumentController::class, 'upload'],
    'document/download' => [DocumentController::class, 'download'],

    'responsable/voyages' => [VoyageController::class, 'mine'],
    'responsable/voyage/create' => [VoyageController::class, 'create'],
    'responsable/voyage/store' => [VoyageController::class, 'store'],
    'responsable/voyage/edit' => [VoyageController::class, 'edit'],
    'responsable/voyage/update' => [VoyageController::class, 'update'],
    'responsable/voyage/archive' => [VoyageController::class, 'archive'],
    'responsable/inscriptions' => [VoyageController::class, 'inscriptions'],

    'admin/dashboard' => [AdminController::class, 'dashboard'],
    'admin/users' => [AdminController::class, 'users'],
    'admin/users/store' => [AdminController::class, 'storeUser'],
    'admin/users/update' => [AdminController::class, 'updateUser'],
    'admin/voyages' => [AdminController::class, 'voyages'],
    'admin/documents' => [DocumentController::class, 'adminIndex'],
    'admin/voyage/validate' => [AdminController::class, 'validateVoyage'],
    'admin/voyage/refuse' => [AdminController::class, 'refuseVoyage'],
    'admin/voyage/archive' => [AdminController::class, 'archiveVoyage'],
];

$route = current_route();

if (!isset($routes[$route])) {
    http_response_code(404);
    $controller = new class extends Controller {
        public function show(): void
        {
            $this->view('errors/404', ['title' => 'Page introuvable']);
        }
    };
    $controller->show();
    exit;
}

[$controllerClass, $method] = $routes[$route];

try {
    $controller = new $controllerClass();
    $controller->$method();
} catch (PDOException $exception) {
    http_response_code(500);
    $message = 'Erreur de base de donnees. Verifiez la configuration MySQL.';
    require VIEW_PATH . DIRECTORY_SEPARATOR . 'errors' . DIRECTORY_SEPARATOR . '500.php';
} catch (Throwable $exception) {
    http_response_code(500);
    $message = 'Une erreur inattendue est survenue.';
    require VIEW_PATH . DIRECTORY_SEPARATOR . 'errors' . DIRECTORY_SEPARATOR . '500.php';
}

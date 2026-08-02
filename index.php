<?php
// index.php - Front Controller / Router
session_start();

// Forsiranje UTF-8 HTTP headera
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

// Uključivanje zajedničkih fajlova
require_once 'config.php';

// Parsiranje rute
$route = $_GET['route'] ?? '';

// Jednostavni ruter
switch ($route) {
    case 'login':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController($conn);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->login();
        } else {
            $auth->showLogin();
        }
        break;

    case 'logout':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController($conn);
        $auth->logout();
        break;

    case 'admin':
        require_once 'controllers/AdminController.php';
        $admin = new AdminController($conn);
        $admin->index();
        break;

    case 'organize_class':
        require_once 'controllers/OrganizeClassController.php';
        $oc = new OrganizeClassController($conn);
        $oc->index();
        break;

    case 'download_test_answers':
        require_once 'controllers/DownloadTestAnswersController.php';
        $download = new DownloadTestAnswersController($conn);
        $download->handleRequest();
        break;

    case 'take_test':
        require_once 'controllers/TakeTestController.php';
        $take = new TakeTestController($conn);
        $take->handleRequest();
        break;

    case 'submit_test':
        require_once 'controllers/SubmitTestController.php';
        $submit = new SubmitTestController($conn);
        $submit->handleRequest();
        break;

    case 'edit_test':
        require_once 'controllers/EditTestController.php';
        $etc = new EditTestController($conn);
        $viewData = $etc->handleRequest();
        if (isset($viewData['redirect'])) { header('Location: ' . $viewData['redirect']); exit; }
        if (isset($viewData['error_die'])) { die($viewData['error_die']); }
        extract($viewData);
        require 'views/admin/edit_test.php';
        break;

    case '':
    case 'student':
        require_once 'controllers/StudentController.php';
        $student = new StudentController($conn);
        $student->index();
        break;

    case 'view_test_results':
    case 'delete_test_result':
    case 'update_answer_points':
        require_once 'controllers/ViewTestResultsController.php';
        $vtr = new ViewTestResultsController($conn);
        $vtr->handleRequest();
        break;

    default:
        http_response_code(404);
        die("Putanja nije pronađena (404)");
}

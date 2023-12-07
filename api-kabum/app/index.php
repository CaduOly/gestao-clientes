<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit();
}
require_once 'controllers/ClienteController.php';

$controller = new ClienteController(new ClienteService(new ClienteRepository($pdo)));

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$segments = explode('/', trim($uri, '/'));

if ($segments[0] === 'cliente') {
    if ($method === 'GET') {
        if (isset($segments[1]) && is_numeric($segments[1])) {
            $controller->getClienteById($segments[1]);
        } else {
            $controller->getAllClientes();
        }
    } elseif ($method === 'POST' && isset($segments[1]) && $segments[1] === 'cadastro') {
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->addCliente($data);
    } elseif ($method === 'PUT' && isset($segments[1]) && is_numeric($segments[1])) {
        $id = $segments[1];
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->updateCliente($id, $data);
    } elseif ($method === 'DELETE' && isset($segments[1]) && is_numeric($segments[1])) {
        $controller->removeCliente($segments[1]);
    } else {
        header('HTTP/1.0 405 Method Not Allowed');
        echo 'Método não permitido';
    }
} else {
    header('HTTP/1.0 404 Not Found');
    echo 'Rota não encontrada';
}

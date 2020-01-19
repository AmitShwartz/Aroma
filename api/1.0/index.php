<?php
include_once '../config/headers.php';
include_once '../config/Database.php';
include_once '../controllers/ModelController.php';
include_once '../controllers/UserController.php';

$database = new Database();
$dbConnection = $database->connect();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$tables = ['categories', 'contents', 'items', 'messages','users'];
if (in_array($uri[4], $tables)) {
    $table = $uri[4];
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}


// the user id is, of course, optional and must be a number:
$id = null;
if (isset($uri[5])) {
    $id = (int)$uri[5];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($uri[4] == 'users'){
    // pass the request method and id to the UserController and process the HTTP request:
    $controller = new UserController($dbConnection, $requestMethod, $id);
}else{
    // pass the request method and id to the ModelController and process the HTTP request:
    $controller = new ModelController($dbConnection, $table, $requestMethod, $id);
}

$controller->processRequest();
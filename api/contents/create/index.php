<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../../../config/Database.php';
include_once '../../../models/Content.php';

// init DB & connect
$database = new Database();
$db = $database->connect();
$content = new Content($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));
$content->info = $data->info;
$content->title = $data->title;

// Create message
if($content->create()) {
    echo json_encode(
        array('message' => 'content Created')
    );
} else {
    echo json_encode(
        array('message' => 'content Not Created')
    );
}
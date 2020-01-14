<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, imageization, X-Requested-With');
include_once '../../config/Database.php';
include_once '../../models/Content.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();
$content = new Content($db);

// Get raw message data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$content->id = $data->id;
$content->info = $data->info;
$content->title = $data->title;
$content->active = $data->active;

// Update message
if($content->update()) {
    echo json_encode(
        array('message' => 'content Updated')
    );
} else {
    echo json_encode(
        array('message' => 'content Not Updated')
    );
}
<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, imageization, X-Requested-With');
include_once '../../config/Database.php';
include_once '../../models/Message.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();
$message = new Message($db);

// Get raw message data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$message->id = $data->id;
$message->responded = $data->responded;

// Update message
if($message->update()) {
    echo json_encode(
        array('message' => 'message Updated')
    );
} else {
    echo json_encode(
        array('message' => 'message Not Updated')
    );
}
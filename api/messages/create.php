<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../../config/Database.php';
include_once '../../models/Message.php';

// init DB & connect
$database = new Database();
$db = $database->connect();
$message = new Message($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));
$message->content = $data->content;
$message->cause = $data->cause;

// Create message
if($message->create()) {
    echo json_encode(
        array('message' => 'message Created')
    );
} else {
    echo json_encode(
        array('message' => 'message Not Created')
    );
}
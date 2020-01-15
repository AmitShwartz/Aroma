<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../../config/Database.php');
include_once('../../../models/Message.php');

$database = new Database();
$db = $database->connect();

$message = new Message($db);
// Get ID
$message->id = isset($_GET['id']) ? $_GET['id'] : die();
// Get message
$message->read_single();
// Create array
$message_arr = array(
    'id' => $message->id,
    'content' => $message->content,
    'cause' => $message->cause
);
// Make JSON
print_r(json_encode($message_arr));
<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../../../config/Database.php';
include_once '../../../models/Item.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

$item = new Item($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));
$item->title = $data->title;
$item->description = $data->description;
$item->image = $data->image;
$item->category_id = $data->category_id;

// Create item
if($item->create()) {
    echo json_encode(
        array('message' => 'Item Created')
    );
} else {
    echo json_encode(
        array('message' => 'Item Not Created')
    );
}
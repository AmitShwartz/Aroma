<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, imageization, X-Requested-With');
include_once '../../config/Database.php';
include_once '../../models/Item.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();
// Instantiate blog Item object
$item = new Item($db);
// Get raw Item data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$item->id = $data->id;
$item->title = $data->title;
$item->description = $data->description;
$item->image = $data->image;
$item->category_id = $data->category_id;

// Update Item
if($item->update()) {
    echo json_encode(
        array('message' => 'Item Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Item Not Updated')
    );
}
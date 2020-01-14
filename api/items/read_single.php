<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Item.php');

$database = new Database();
$db = $database->connect();

$item = new Item($db);
// Get ID
$item->id = isset($_GET['id']) ? $_GET['id'] : die();
// Get item
$item->read_single();
// Create array
$item_arr = array(
    'id' => $item->id,
    'title' => $item->title,
    'description' => $item->description,
    'image' => $item->image,
    'category_id' => $item->category_id
);
// Make JSON
print_r(json_encode($item_arr));
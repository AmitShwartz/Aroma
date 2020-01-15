<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../../config/Database.php');
include_once('../../../models/Content.php');

$database = new Database();
$db = $database->connect();

$content = new Content($db);
// Get ID
$content->id = isset($_GET['id']) ? $_GET['id'] : die();
// Get message
$content->read_single();
// Create array
$message_arr = array(
    'id' => $content->id,
    'info' => $content->info,
    'title' => $content->title,
    'active'=>$content->active
);
// Make JSON
print_r(json_encode($message_arr));
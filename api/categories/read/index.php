<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../../../config/Database.php';
include_once '../../../models/Category.php';

// init DB & connect
$database = new Database();
$db = $database->connect();
$category = new Category($db);

// Category read_single query
$result = $category->read();


// Check if any categories
if($result->rowCount() > 0) {
    // Cat array
    $cat_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $cat_item = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'image' => $row['image'],
        );
        // Push to "data"
        array_push($cat_arr, $cat_item);
    }
    // Turn to JSON & output
    echo json_encode($cat_arr);
} else {
    // No Categories
    echo json_encode(
        array('message' => 'No Categories Found')
    );
}
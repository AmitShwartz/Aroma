<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Item.php');

$database = new Database();
$db = $database->connect();

$item = new Item($db);
$result = $item->read();

if ($result->rowCount() > 0) {
    $items_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $item = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'category_id' => $row['category_id'],
            'category_title' => $row['category_title'],
            'image' => $row['image']
        );

        array_push($items_arr, $item);
    }
    echo json_encode($items_arr);
} else {
    echo json_encode(
        array('massage'=>'No items found.')
    );
}

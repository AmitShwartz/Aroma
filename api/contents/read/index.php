<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../../config/Database.php');
include_once('../../../models/Content.php');

$database = new Database();
$db = $database->connect();

$content = new Content($db);
$result = $content->read();

if ($result->rowCount() > 0) {
    $content_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $content = array(
            'id' => $row['id'],
            'info' => $row['info'],
            'title' => $row['title'],
            'active' => $row['active']
        );

        array_push($content_arr, $content);
    }
    echo json_encode($content_arr);
} else {
    echo json_encode(
        array('massage' => 'No messages found.')
    );
}

<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Message.php');

$database = new Database();
$db = $database->connect();

$message = new Message($db);
$result = $message->read();

if ($result->rowCount() > 0) {
    $messages_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $message = array(
            'id' => $row['id'],
            'content' => $row['content'],
            'cause' => $row['cause'],
            'responded' => $row['responded']
        );

        array_push($messages_arr, $message);
    }
    echo json_encode($messages_arr);
} else {
    echo json_encode(
        array('massage' => 'No messages found.')
    );
}

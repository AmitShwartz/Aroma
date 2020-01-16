<?php

// init DB & connect
$database = new Database();
$db = $database->connect();

function create()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"));

    $content = new Model(
        $db,
        'contents',
        [
            'title' => $data->title,
            'info' => $data->info
        ]
    );
// Create message
    if ($content->create()) {
        echo json_encode(
            array('message' => 'content Created')
        );
    } else {
        echo json_encode(
            array('message' => 'content Not Created')
        );
    }
}

function getAll()
{
    global $db;
    $content = new Model($db, 'contents');
    $result = $content->getAll();

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
}

function getSingle()
{
    global $db;
    $content = new Model($db, 'contents', ['id' => $_GET['id']]);

    $content->getSingle();
// Create array
    $content_arr = array(
        'id' => $content->columns['id'],
        'info' => $content->columns['info'],
        'title' => $content->columns['title'],
        'active' => $content->columns['active']
    );
// Make JSON
    print_r(json_encode($content_arr));
}

function delete()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"));
    $content = new Model($db, 'contents', ['id' => $data->id]);

// Delete message
    if ($content->delete()) {
        echo json_encode(
            array('message' => 'content Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'content Not Deleted')
        );
    }
}

function update()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"));
    $content = new Model(
        $db,
        'contents',
        [
            'id' => $data->id,
            'info' => $data->info,
            'title' => $data->title,
            'active' => $data->active
        ]
    );

// Update message
    if ($content->update()) {
        echo json_encode(
            array('message' => 'content Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'content Not Updated')
        );
    }
}

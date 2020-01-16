<?php
// init DB & connect
$database = new Database();
$db = $database->connect();

function create()
{
    global $db;

    $data = json_decode(file_get_contents("php://input"));

    $category = new Model(
        $db,
        "categories",
        ['title' => $data->title, 'image' => $data->image]
    );

    if ($category->create()) {
        echo json_encode(
            array('message' => 'Category Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Created')
        );
    }
}

function delete()
{
    global $db;
    $data = json_decode(file_get_contents("php://input"));
    $category = new Model($db, 'categories', ['id' => $data->id]);

// Delete post
    if ($category->delete()) {
        echo json_encode(
            array('message' => 'Category deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Category not deleted')
        );
    }
}

function getAll(){
    global $db;
    $category = new Model($db,'categories');

// Category read_single query
    $result = $category->getAll();

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
}
function getSingle(){
    global $db;
    $category = new Model($db, 'categories',['id'=>$_GET['id']]);

    $category->getSingle();
// Create array
    $item_arr = array(
        'id' => $category->columns['id'],
        'title' => $category->columns['title'],
        'image' => $category->columns['image'],
    );
// Make JSON
    print_r(json_encode($item_arr));

}


function update(){
    global $db;
    $data = json_decode(file_get_contents("php://input"));
    $category = new Model(
        $db,
        'categories',
        [
            'id'=>$data->id,
            'title'=>$data->title,
            'image'=>$data->image
        ]
    );
// Update post
    if($category->update()) {
        echo json_encode(
            array('message' => 'Category Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Category not updated')
        );
    }
}

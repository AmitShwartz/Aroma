<?php
include_once '../models/Model.php';
class ModelController
{
    protected $model;
    protected $requestMethod;
    protected $id;
    protected $table;

    public function __construct($db, $table, $requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->id = $id;
        $this->table = $table;
        $this->model = new Model(
            $db,
            $table
        );

    }

    protected function setColumns()
    {
        $data = json_decode(file_get_contents("php://input"));
        $this->model->columns = (array)$data;
    }

    protected function create()
    {
        $this->setColumns();
        if ($this->model->create()) {
            echo json_encode(
                array('message' => 'Object created in '. $this->table. ' table')
            );
        } else {
            echo json_encode(
                array('message' => 'Object not created in '.$this->table. ' table')
            );
        }
    }

    protected function delete()
    {
        $this->setColumns();
// Delete post
        if ($this->model->delete()) {
            echo json_encode(
                array('message' => 'Object deleted from '. $this->table. ' table')
            );
        } else {
            echo json_encode(
                array('message' => 'Object not deleted from '. $this->table. ' table')
            );
        }
    }

    protected function getAll()
    {
        $this->setColumns();
        $result = $this->model->getAll();

// Check if any data
        if ($result->rowCount() > 0) {
            // Cat array
            $cat_arr = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                array_push($cat_arr, $row);
            }
            // Turn to JSON & output
            echo json_encode($cat_arr);
        } else {
            echo json_encode(
                array('message' => 'No '.$this->table.' found')
            );
        }
    }

    protected function getSingle()
    {
        $this->model->columns['id'] = $this->id;
        $this->model->getSingle();
        // Make JSON
        print_r(json_encode($this->model->columns));

    }

    protected function update()
    {
        $this->setColumns();
// Update post
        if ($this->model->update()) {
            echo json_encode(
                array('message' => 'Object updated in '. $this->table. ' table')
            );
        } else {
            echo json_encode(
                array('message' => 'Object not updated in '. $this->table. ' table')
            );
        }
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->id) {
                    $this->getSingle($this->id);
                } else {
                    $this->getAll();
                };
                break;
            case 'POST':
                $this->create();
                break;
            case 'PUT':
                $this->update();
                break;
            case 'DELETE':
                $this->delete();
                break;
            default:
                header("HTTP/1.1 404 Not Found");
                exit();
                break;
        }
    }
}
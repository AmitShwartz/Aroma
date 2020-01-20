<?php
include_once 'ModelController.php';
include_once '../models/User.php';

class UserController extends ModelController
{
    public function __construct($db, $requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->id = $id;
        $this->table = 'users';
        $this->model = new User($db);
    }

    public function create()
    {
        $this->setColumns();
        foreach ($this->model->columns as $value) {
            if (empty($value)) {
                echo json_encode(
                    array('message' => 'Object not created in ' . $this->table . ' table')
                );
                return;
            }
        }
        if ($this->model->create()) {
            echo json_encode(
                array('message' => 'Object created in ' . $this->table . ' table')
            );
        } else {
            echo json_encode(
                array('message' => 'Object not created in ' . $this->table . ' table')
            );
        }
    }
}
<?php
include_once '../../config/headers.php';
include_once 'controllers.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'PUT':
        update();
        break;
    case 'DELETE':
        delete();
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            getSingle();
        } else {
            getAll();
        }
        break;
    case 'POST':
        create();
        break;
    default:
        break;
}
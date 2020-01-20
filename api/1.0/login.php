<?php
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
include_once '../config/database.php';
include_once '../config/headers.php';
include_once '../models/User.php';

// get database connection
$database = new Database();
$db = $database->connect();

// instantiate user object
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
$user->columns['name'] = $data->name;
$name_exists = $user->nameExists();

// check if email exists and if password is correct
if ($name_exists && password_verify($data->password, $user->columns['password'])) {
    $token = array(
        "iss" => 'localhost/aroma/api/1.0',
        "iat" => time(),
        "data" => array(
            "id" => $user->columns['id'],
            "name" => $user->columns['name'],
        )
    );
// set response code
    http_response_code(200);

// generate jwt
    $jwt = JWT::encode($token, 'aroma');
    echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt
        )
    );
} // login failed
else {

// set response code
    http_response_code(401);

// tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}

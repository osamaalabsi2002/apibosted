<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include 'connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $user_name = $_POST['user_name'] ?? '';
    $user_email = $_POST['user_email'] ?? '';
    $user_phoneNum = $_POST['user_phoneNum'] ?? '';
    $user_image = $_POST['user_image'] ?? '';
    $role_id = $_POST['role_id'] ?? '';
    $password = $_POST['password'] ?? '';

 
    if (empty($user_name) || empty($user_email) || empty($user_phoneNum) || empty($user_image) || empty($role_id) || empty($password)) {
        http_response_code(400);
        $response['status'] = 'error';
        $response['message'] = 'Please fill all required fields';
    } else {

        $sql = "INSERT INTO users (user_name, user_email, user_phoneNum, user_image, role_id, password, user_dateCreated) 
                VALUES ('$user_name', '$user_email', '$user_phoneNum', '$user_image', '$role_id', '$password', NOW())";
        
        if ($conn->query($sql) === TRUE) {
            http_response_code(201);
            $response['status'] = 'success';
            $response['message'] = 'User created successfully';
        } else {
            http_response_code(500);
            $response['status'] = 'error';
            $response['message'] = 'Server error: ' . $conn->error;
        }
    }
} else {
    http_response_code(405);
    $response['status'] = 'error';
    $response['message'] = 'Request method not supported';
}

echo json_encode($response);

$conn->close();
?>

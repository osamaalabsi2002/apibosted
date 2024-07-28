<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include 'connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $user_email = $_POST['user_email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($user_email) || empty($password)) {
        http_response_code(400);
        $response['status'] = 'error';
        $response['message'] = 'Please fill all required fields';
    } else {
   
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
          
            if ($password === $row['password']) { // Direct comparison without hashing
                http_response_code(200);
                $response['status'] = 'success';
                $response['message'] = 'Login successful';
            } else {
                http_response_code(401);
                $response['status'] = 'error';
                $response['message'] = 'Invalid password';
            }
        } else {
            http_response_code(404);
            $response['status'] = 'error';
            $response['message'] = 'Email not found';
        }

        $stmt->close();
    }
} else {
    http_response_code(405);
    $response['status'] = 'error';
    $response['message'] = 'Request method not supported';
}

echo json_encode($response);

$conn->close();
?>

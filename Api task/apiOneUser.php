<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include 'connection.php';

// Check if 'id' parameter is provided in the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize response array
$response = array();

if ($id > 0) {
    // Prepare and execute SQL query to fetch data for the specific user
    $sql = "SELECT * FROM users WHERE user_id = $id"; // Make sure the column name is correct
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $response['status'] = "success";
        $response['data'] = $result->fetch_assoc();
    } else {
        $response['status'] = "error";
        $response['message'] = "No record found for ID $id";
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Invalid ID provided";
}

// Output the JSON response
echo json_encode($response);

$conn->close();
?>

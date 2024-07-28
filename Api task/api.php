<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');


include 'connection.php';


$sql = "SELECT * FROM users";
$result = $conn->query($sql);


$response = array();

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    $response = array("status" => "error", "message" => "No records found");
}

echo json_encode($response);


$conn->close();
?>

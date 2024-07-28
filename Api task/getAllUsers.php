<?php
// URL to the api.php file
$apiUrl = 'http://localhost:8080/Demo/Api%20task/api.php';


$ch = curl_init();


curl_setopt($ch, CURLOPT_URL, $apiUrl);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response, true);

// Display the data
if (isset($data['status']) && $data['status'] === 'error') {
    echo "<p>" . $data['message'] . "</p>";
} else {
    echo "<ul>";
    foreach ($data as $user) {
        echo "<li>ID: " . $user['user_id'] . ", Name: " . $user['user_name'] .  ", Phone: " . $user['user_phoneNum'] . "</li>";
    }
    echo "</ul>";
}
?>

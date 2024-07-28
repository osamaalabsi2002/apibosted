<?php

// Check if the ID parameter is set
if (isset($_POST["id"])) {
    $userId = intval($_POST["id"]);

    // API URL with the ID parameter
    $apiUrl = "http://localhost:8080/Demo/Api%20task/apiOneUser.php?id=$userId";

    // Using cURL to fetch data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo "<p>Error: " . curl_error($ch) . "</p>";
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if the data is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "<p>Error decoding JSON response: " . json_last_error_msg() . "</p>";
    } elseif (isset($data['status']) && $data['status'] === 'error') {
        echo "<p>" . $data['message'] . "</p>";
    } elseif (isset($data['status']) && $data['status'] === 'success') {
        // Display the data
        $user = $data['data'];
        echo "<p>ID: " . $user['user_id'] . "</p>";
        echo "<p>Name: " . $user['user_name'] . "</p>";
        echo "<p>Email: " . $user['user_email'] . "</p>";
        echo "<p>Date Created: " . $user['user_dateCreated'] . "</p>";
        echo "<p>Phone Number: " . $user['user_phoneNum'] . "</p>";
        echo "<p>Role ID: " . $user['role_id'] . "</p>";
        echo "<p>User Image: <img src='" . $user['user_image'] . "' alt='User Image' /></p>";
    } else {
        echo "<p>Unexpected response format.</p>";
    }
} else {
    echo "<p>Please enter a valid user ID.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch User Data</title>
</head>
<body>
    <form action="oneUser.php" method="POST">
        <input type="text" name="id" placeholder="Enter User ID">
        <input type="submit" value="Fetch User">
    </form>
</body>
</html>

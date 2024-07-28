<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    // Get data from the form
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_phoneNum = $_POST['user_phoneNum'];
    $user_image = $_POST['user_image'];
    $role_id = $_POST['role_id'];
    $password = $_POST['password'];

    $apiUrl = "http://localhost:8080/Demo/Api%20task/apiCreate.php";

    $postData = array(
        'user_name' => $user_name,
        'user_email' => $user_email,
        'user_phoneNum' => $user_phoneNum,
        'user_image' => $user_image,
        'role_id' => $role_id,
        'password' => $password
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "<p>Error: " . curl_error($ch) . "</p>";
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Display the appropriate message
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<p>" . $data['message'] . "</p>";
    } else {
        echo "<p>Error decoding JSON response: " . json_last_error_msg() . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
</head>
<body>
    <h1>Add New User</h1>
    <form action="createUser.php" method="POST">
        <input type="hidden" name="action" value="add">
        <input type="text" name="user_name" placeholder="Username" required>
        <input type="email" name="user_email" placeholder="Email" required>
        <input type="text" name="user_phoneNum" placeholder="Phone Number" required>
        <input type="text" name="user_image" placeholder="User Image" required>
        <input type="text" name="role_id" placeholder="Role ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Add User">
    </form>
</body>
</html>

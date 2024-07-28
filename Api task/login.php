<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <input type="email" name="user_email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // API URL
        $apiUrl = "http://localhost:8080/Demo/Api%20task/apiLogin.php";

        // Data to be sent to the API
        $postData = array(
            'user_email' => $_POST['user_email'],
            'password' => $_POST['password']
        );

        // cURL to send data to the API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo "<p>Error: " . curl_error($ch) . "</p>";
            curl_close($ch);
            exit;
        }

        curl_close($ch);

        // Decode JSON response
        $data = json_decode($response, true);

        // Display the appropriate message
        if (json_last_error() === JSON_ERROR_NONE) {
            echo "<p>" . $data['message'] . "</p>";
        } else {
            echo "<p>JSON Decode Error: " . json_last_error_msg() . "</p>";
        }
    }
    ?>
</body>
</html>

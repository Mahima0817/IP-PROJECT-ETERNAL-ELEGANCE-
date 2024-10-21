<?php
$hostname = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "eternal_elegance";

$conn = new mysqli($hostname, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$successURL = 'index.html';
$errorURL = 'login.html';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    
    $stmt = $conn->prepare("SELECT * FROM user_details WHERE user_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $message = "Login successful!";
            echo "<script>
                alert('$message');
                window.location.href = '$successURL';
            </script>";
        } else {
            $message = "Error: Invalid username or password.";
            echo "<script>
                alert('$message');
                window.location.href='$errorURL';
            </script>";
        }
    } else {
        $message = "Error: Invalid username or password.";
        echo "<script>
            alert('$message');
            window.location.href='$errorURL';
        </script>";
    }
}

$conn->close();
?>

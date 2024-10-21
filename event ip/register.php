<?php
$hostname = "localhost"; // Change if necessary
$db_username = "root"; // Your MySQL username
$db_password = ""; // Your MySQL password
$dbname = "eternal_elegance"; // Your database name

// Create connection
$conn = new mysqli($hostname, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for messages
$message = '';
$successURL = 'login.html'; // Page to redirect on success
$errorURL = 'register.html'; // Page to redirect on error

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirm_password']); // New field for confirm password
    
    // Check if the passwords match
    if ($password !== $confirmPassword) {
        $message = "Error: Passwords do not match. Please try again.";
        
        // Redirect with JavaScript alert for error
        echo "<script>
            alert('$message');
            window.location.href='$errorURL';
        </script>";
    } else {
        // Check if the username already exists
        $checkSql = "SELECT * FROM user_details WHERE user_name='$username'";
        $result = $conn->query($checkSql);
        
        if ($result->num_rows > 0) {
            $message = "Error: Username already exists. Please choose a different username.";
            
            // Redirect with JavaScript alert for error
            echo "<script>
                alert('$message');
                window.location.href='$errorURL';
            </script>";
        } else {
            // Hash the password before inserting
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user_details (user_name, password) VALUES ('$username', '$hashedPassword')";
            
            if ($conn->query($sql) === TRUE) {
                // Create a table for the user based on the username
                $userTable = "user_" . $username; // Create a unique table name
                
                // SQL query to create the user's table
                $createTableSql = "CREATE TABLE $userTable (
                    task_id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    task_name VARCHAR(255) NOT NULL,
                    task_description TEXT,
                    due_date DATE,
                    status VARCHAR(50) DEFAULT 'pending'
                )";
                
                // Execute table creation query
                if ($conn->query($createTableSql) === TRUE) {
                    $message = "Registration successful!";
                    
                    // Redirect with JavaScript alert for success
                    echo "<script>
                        alert('$message');
                        window.location.href='$successURL';
                    </script>";
                } else {
                    $message = "Error creating user table: " . $conn->error;
                    
                    // Redirect with JavaScript alert for error
                    echo "<script>
                        alert('$message');
                        window.location.href='$errorURL';
                    </script>";
                }
            } else {
                $message = "Error: " . $conn->error;
                
                // Redirect with JavaScript alert for error
                echo "<script>
                    alert('$message');
                    window.location.href='$errorURL';
                </script>";
            }
        }
    }
}

// Close the database connection
$conn->close();
?>

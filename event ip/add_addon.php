<?php
// Database connection settings
$servername = "localhost"; // Change this to your database server if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "eternal_elegance"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the data was sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if selectedItems is set and not empty
    if (isset($_POST['selectedItems']) && !empty(trim($_POST['selectedItems']))) {
        // Get the selected items
        $items = $_POST['selectedItems'];
        // Split the items into an array
        $itemArray = explode(',', $items);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO selected_addons (addon_name) VALUES (?)");
        $stmt->bind_param("s", $item);

        $success = false; // Flag to track if any addon was successfully added

        // Loop through the items and execute the statement for each
        foreach ($itemArray as $item) {
            $item = trim($item); // Trim whitespace
            if (!empty($item)) { // Check if the item is not empty
                if ($stmt->execute()) {
                    $success = true; // Set flag to true if an item was added
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>"; // Output error if insert fails
                }
            }
        }

        // Display success message with animation
        if ($success) {
            echo "
            <div class='alert alert-success animated'>
                <h2 style='text-align: center;'>All addons added successfully!</h2>
                <p style='text-align: center;'>Thank you for selecting your addons!</p>
            </div>
            <style>
                .animated {
                    animation: fadeIn 1s ease-in-out;
                    background: linear-gradient(to right, #00c6ff, #0072ff);
                    color: white;
                    padding: 20px;
                    border-radius: 10px;
                    text-align: center;
                }
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
            </style>
            ";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Creative message when no addons are selected
        echo "
        <div class='alert alert-warning animated'>
            <h2 style='text-align: center;'>Oops! No Addons Selected!</h2>
            <p style='text-align: center;'>Looks like you forgot to choose some addons. <br> 
            Don't worry, just head back and select the ones you want!</p>
            <div style='text-align: center;'>
                <img src='mahi1.jpg' alt='Sad Face' style='width: 100px;'>
            </div>
        </div>
        <style>
            .animated {
                animation: shake 0.5s ease-in-out;
                background-color: #ffcccb;
                color: #ff0000;
                padding: 20px;
                border-radius: 10px;
                text-align: center;
            }
            @keyframes shake {
                0% { transform: translate(1px, 1px) rotate(0deg); }
                25% { transform: translate(-1px, -2px) rotate(-1deg); }
                50% { transform: translate(-3px, 0px) rotate(1deg); }
                75% { transform: translate(2px, 2px) rotate(0deg); }
                100% { transform: translate(1px, -1px) rotate(0deg); }
            }
        </style>
        ";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request method.</div>";
}

// Close connection
$conn->close();
?>


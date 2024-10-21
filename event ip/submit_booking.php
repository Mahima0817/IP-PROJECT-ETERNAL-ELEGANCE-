<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eternal_elegance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Insert data into the database when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $event_date = $_POST['date'];
    $venue = $_POST['venue'];

    // SQL query to insert data
    $sql = "INSERT INTO birthday_bookings (name, event_date, venue) VALUES (?, ?, ?)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);

    // Debug: Check if prepare() failed
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    $stmt->bind_param("sss", $name, $event_date, $venue);

    // Execute the statement
    if ($stmt->execute()) {
        echo "
        <div id='successOverlay' class='full-page-overlay'>
            <div class='success-message'>
                Booking successfully created!
            </div>
            <div class='revisit-message'>
                Explore more exciting features on <strong>Eternal Elegance</strong>! 
                <br> From grand celebrations to intimate gatherings, we make every event magical!
            </div>
            <div class='confetti-container'></div>
        </div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!-- Add the following CSS styles for the animation -->
<style>
    .full-page-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        animation: fadeIn 1s, scaleUp 0.5s ease-in-out forwards;
    }

    .success-message {
        font-size: 2rem;
        margin: 20px;
        animation: bounce 1s infinite;
    }

    .revisit-message {
        font-size: 1.2rem;
        text-align: center;
        margin-bottom: 20px;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scaleUp {
        from { transform: scale(0.5); }
        to { transform: scale(1); }
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-30px); }
        60% { transform: translateY(-15px); }
    }
</style>

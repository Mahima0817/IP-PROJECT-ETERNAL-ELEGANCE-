<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost";
$username = "root"; // Change this if needed
$password = ""; // Change this if needed
$dbname = "eternal_elegance"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into the database when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $couple_name = $_POST['coupleName'];
    $wedding_date = $_POST['weddingDate'];
    $venue = $_POST['venue'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO wedding_bookings (couple_name, wedding_date, venue) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $couple_name, $wedding_date, $venue);

    // Execute the statement
    if ($stmt->execute()) {
        // Success message with animation
        echo "
        <div id='successOverlay' class='full-page-overlay'>
            <div class='success-message'>
                Wedding booking successfully created!
            </div>
            <div class='revisit-message'>
                Explore more magical moments at <strong>Eternal Elegance</strong>! 
                <br> Celebrate love, laughter, and happily ever after!
            </div>
            <div class='confetti-container'></div> <!-- Container for the confetti animation -->
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

<!-- Include jQuery for animation -->
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>

<!-- JavaScript for Confetti and Grand Animation -->
<script>
    $(document).ready(function() {
        $('#successOverlay').hide().fadeIn(1000).delay(5000).fadeOut(1000); // Fade in and out overlay
        
        // Confetti animation setup
        setTimeout(function() {
            // Confetti generator function
            function generateConfetti() {
                let confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw'; // Random horizontal position
                document.querySelector('.confetti-container').appendChild(confetti);
                setTimeout(function() {
                    confetti.remove(); // Remove after animation to avoid clutter
                }, 3000);
            }

            // Generate confetti every 200ms
            let confettiInterval = setInterval(generateConfetti, 200);

            // Stop confetti after 5 seconds
            setTimeout(function() {
                clearInterval(confettiInterval);
            }, 5000);
        }, 1000); // Start confetti after 1-second delay
        
        // Redirect after the animation ends
        setTimeout(function() {
            window.location.href = 'wedding.html'; // Replace with the desired redirect page
        }, 7000); // Redirect after 7 seconds
    });
</script>

<!-- Enhanced CSS for Full-Page Grand Animation -->
<style>
    /* Full-screen overlay */
    .full-page-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #ff6f91, #ff9671, #ffc75f, #f9f871);
        background-size: 300% 300%;
        animation: gradientShift 8s ease infinite;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        color: #fff;
        text-align: center; /* Center-align text */
    }

    /* Animation for shifting background gradient */
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Success message styling */
    .success-message {
        font-size: 4rem;
        color: #fff;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.7), 0 0 30px rgba(255, 255, 255, 0.5);
        animation: textGlow 1.5s ease-in-out infinite alternate, bounceIn 1s ease;
    }

    /* Revisit message styling */
    .revisit-message {
        font-size: 2rem;
        margin-top: 20px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        animation: fadeInUp 1.5s ease-in-out;
    }

    /* Text glow animation */
    @keyframes textGlow {
        from {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7), 0 0 30px rgba(255, 255, 255, 0.5), 0 0 40px rgba(255, 255, 255, 0.4);
        }
        to {
            text-shadow: 0 0 40px rgba(255, 255, 255, 0.9), 0 0 60px rgba(255, 255, 255, 0.6), 0 0 80px rgba(255, 255, 255, 0.5);
        }
    }

    /* Bounce-in animation for success message */
    @keyframes bounceIn {
        0% {
            transform: scale(0.7);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }

    /* Fade-in effect for the revisit message */
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Confetti styling */
    .confetti-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: rgba(255, 255, 255, 0.9);
        animation: confettiFall 2s linear infinite, confettiDrift 2s ease-in-out infinite;
    }

    /* Confetti falling animation */
    @keyframes confettiFall {
        0% { top: -10%; }
        100% { top: 100%; }
    }

    /* Confetti drift left and right */
    @keyframes confettiDrift {
        0% { transform: translateX(0); }
        50% { transform: translateX(20px); }
        100% { transform: translateX(-20px); }
    }
</style>

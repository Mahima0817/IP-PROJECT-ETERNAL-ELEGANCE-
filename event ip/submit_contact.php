<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = htmlspecialchars($_POST['name']);
    $contact = htmlspecialchars($_POST['contact']);
    $message = htmlspecialchars($_POST['message']);

    // Here you can add your code to store or process the message
    // For now, we will just display the thank you message

    // HTML and JavaScript for the thank you message with animation
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Thank You - Eternal Elegance</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-image: url("background-image.jpg"); /* Replace with your background image */
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden; /* Hide overflow for confetti */
            }

            .thank-you-message {
                background-color: rgba(255, 255, 255, 0.9);
                padding: 40px;
                border-radius: 10px;
                text-align: center;
                animation: slideIn 1s ease;
                position: relative;
            }

            @keyframes slideIn {
                from {
                    transform: translateY(-100%);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .confetti {
                position: absolute;
                width: 100%;
                height: 100%;
                pointer-events: none;
                overflow: hidden;
                z-index: 9999; /* Ensure confetti appears above everything */
            }
        </style>
    </head>
    <body>

        <div class="confetti" id="confetti"></div>

        <div class="thank-you-message">
            <h1>Thank You!</h1>
            <p>Your message has been sent successfully.</p>
            <p>We will get back to you shortly!</p>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Confetti effect
            function createConfetti() {
                const colors = ["#FF0A0A", "#0ABF0A", "#0A83BF", "#BF0A0A", "#BF0AB0"];
                for (let i = 0; i < 100; i++) {
                    const confetti = document.createElement("div");
                    confetti.classList.add("confetti-piece");
                    confetti.style.position = "absolute";
                    confetti.style.width = "10px";
                    confetti.style.height = "10px";
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.left = Math.random() * 100 + "vw"; // random x position
                    confetti.style.top = Math.random() * 100 + "vh"; // random y position
                    confetti.style.opacity = Math.random();
                    confetti.style.transform = "translateY(0)";
                    confetti.style.transition = "transform 2s, opacity 2s";
                    document.getElementById("confetti").appendChild(confetti);
                    
                    // Animate confetti
                    setTimeout(() => {
                        confetti.style.transform = "translateY(100vh)";
                        confetti.style.opacity = 0;
                    }, 10);
                    
                    // Remove confetti piece after animation
                    setTimeout(() => {
                        confetti.remove();
                    }, 2000);
                }
            }

            // Trigger confetti effect after page load
            window.onload = createConfetti;
        </script>
    </body>
    </html>';

    exit();
}
?>


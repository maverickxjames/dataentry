<?php include('header.php') ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <!-- <link rel="stylesheet" href="style.css"> -->

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            width: 80%;
            margin: 50px auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .contact-info {
            flex: 1;
            position: relative;
            background: url('contact-bg.jpg') no-repeat center center;
            background-size: cover;
            padding: 40px;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .contact-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .contact-info .info-container {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .contact-info .info {
            margin-bottom: 30px;
        }

        .contact-info h4 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #fff;
        }

        .contact-info p {
            margin: 0;
            font-size: 16px;
            color: #bfbfbf;
        }

        .contact-info a {
            color: #28a745;
            text-decoration: none;
            transition: color 0.3s;
        }

        .contact-info a:hover,
        .contact-info a:active {
            color: #fff;
        }

        .contact-form {
            flex: 1.5;
            padding: 40px;
            background-color: #fff;
        }

        .contact-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form .form-group.full-width {
            width: 100%;
        }

        .contact-form .form-group input,
        .contact-form .form-group textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .contact-form .form-group input {
            width: calc(100% - 22px);
        }

        .contact-form .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        .contact-form .name-group {
            display: flex;
            justify-content: space-between;
        }

        .contact-form .name-group input {
            width: calc(50% - 10px);
            margin-right: 10px;
        }

        .contact-form .name-group input:last-child {
            margin-right: 0;
        }

        .contact-form textarea {
            height: 100px;
            resize: none;
        }

        .contact-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }

        .contact-form button:hover {
            background-color: #218838;
        }

        /* Animation */
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes underline {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        .char {
            display: inline-block;
            opacity: 0;
            animation: fadeIn 0.7s forwards;
        }

        .space {
            margin-right: 0.2em;
        }

        .underline {
            display: inline-block;
            position: relative;
            font-weight: bold;
        }

        .underline::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            height: 2px;
            width: 100%;
            background-color: currentColor;
            animation: underline 0.7s forwards;
        }
    </style>
    
</head>
<body>
<main>
<?php
include 'db.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    // Validate inputs (you can add more validation as needed)
    if (empty($first_name) || empty($last_name) || empty($email) || empty($message)) {
        echo "Please fill in all required fields.";
    } else {
        // Escape inputs to prevent SQL injection
        $first_name = mysqli_real_escape_string($conn, $first_name);
        $last_name = mysqli_real_escape_string($conn, $last_name);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $message = mysqli_real_escape_string($conn, $message);
        
        // Assuming your status starts as 'unread'
        $status = 'unread';

        // Insert data into database
        $sql = "INSERT INTO contact_msg (date, username, email_id, phone_no, msg, status) 
                VALUES (NOW(), '$first_name $last_name', '$email', '$phone', '$message', '$status')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Message sent successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

    <div class="container">
        <div class="contact-info">
            <div class="info-container">
                <div class="info">
                    <h1 id="get-in-touch"></h1>
                </div>
                <div class="info">
                    <h4>Call Support</h4>
                    <p><a href="tel:+18001236879">+1 800 1236879</a></p>
                </div>
                <div class="info">
                    <h4>Whatsapp Support</h4>
                    <p><a href="https://wa.me/18001236879?text=Hello%2C%20I%20would%20like%20to%20know%20more%20about%20your%20services." class="whatsapp-link">+1 800 1236879</a></p>
                </div>
                <div class="info">
                    <h4>Email Support</h4>
                    <p><a href="mailto:contact@example.com?subject=Inquiry">contact@example.com</a></p>
                </div>
                <div class="info">
                    <h4>Address</h4>
                    <p>Mada Center 8th floor, 379 Hudson St, New York, NY 10018 US</p>
                </div>
            </div>
        </div>
        <div class="contact-form">
            <h2>Send Us A Message</h2>
            <form action="contact.php" method="post">
                <div class="form-group full-width">
                    <label for="name">TELL US YOUR NAME *</label>
                    <div class="name-group">
                        <input type="text" name="first_name" placeholder="First name" required>
                        <input type="text" name="last_name" placeholder="Last name" required>
                    </div>
                </div>
                <div class="form-group full-width">
                    <label for="email">ENTER YOUR EMAIL *</label>
                    <input type="email" name="email" placeholder="Eg. example@email.com" required>
                </div>
                <div class="form-group full-width">
                    <label for="phone">ENTER PHONE NUMBER</label>
                    <input type="text" name="phone" placeholder="Eg. +1 800 000000">
                </div>
                <div class="form-group full-width">
                    <label for="message">MESSAGE *</label>
                    <textarea name="message" placeholder="Write us a message" required></textarea>
                </div>
                <button type="submit">SEND MESSAGE</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const getInTouchText = "Get In Touch";
            const getInTouchContainer = document.getElementById('get-in-touch');

            function createSpans(text, container, startDelay) {
                Array.from(text).forEach((char, index) => {
                    const span = document.createElement('span');
                    span.className = 'char underline';
                    if (char === ' ') {
                        span.classList.add('space');
                    }
                    span.style.animationDelay = `${startDelay + index * 0.1}s`;
                    span.textContent = char;
                    container.appendChild(span);
                });
            }

            function animateText() {
                getInTouchContainer.innerHTML = '';
                createSpans(getInTouchText, getInTouchContainer, 0);
            }

            animateText();

            setInterval(animateText, getInTouchText.length * 100 + 2000); // Reduced repeat time
        });
    </script>
</main>
</body>
</html>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: url('c.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-top: 80px; /* To accommodate fixed navbar */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-custom {
            border-radius: 10px;
            font-size: 16px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-hotel"></i> Hotel Management
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Contact</a>
                </li>
                <?php
                session_start();
                if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
                    $userName = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); // Escape session name for safety
                    echo "<li class='nav-item'>
        <a class='nav-link' href='php/logout.php'>$userName</a>
    </li>";
                    echo "<li class='nav-item'>
        <a class='nav-link' href='mybookings.php'>My bookings</a>
    </li>";
                } else {
                    echo "<li class='nav-item'>
        <a class='nav-link' href='login.php'>Login</a>
    </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Login Form -->
<div class="form-container">
    <h2>Login</h2>
    <form action="#" method="POST">
        <div class="mb-3">
            <label for="Email" class="form-label">Email</label>
            <input type="email" id="Email" name="Email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" name="login" class="btn btn-primary btn-custom"><i class="fas fa-sign-in-alt"></i> LOGIN</button>
            <a href="register.php" class="btn btn-link">Register</a>
        </div>
    </form>
    <?php
    if (isset($_POST["login"])) {
        // Collect form data and sanitize inputs
        $password = trim($_POST["password"]);
        $email = trim($_POST["Email"]);

        // Create connection
        $conn = new mysqli("localhost", "root", "", "hotel");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query the database directly
        $sql = "SELECT * FROM customer WHERE customer_email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows === 1) {
            // Fetch the user data
            $user = $result->fetch_assoc();

            // Verify password (assuming passwords are hashed in the database)
            if ($password == $user["customer_password"]) {
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["name"] = $user["customer_name"];
                $_SESSION["id"] = $user["id"];
                $_SESSION["admin"] = false;

                echo "Login success";
                // Redirect to dashboard or another page
                header("Location: home.php");
                exit;
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with this email.";
        }

        // Close the connection
        $conn->close();
    }
    ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

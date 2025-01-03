<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "hotel");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } else {
        // Query to check admin credentials
        $sql = "SELECT * FROM admins WHERE email = ? AND active = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();
            if ($password === $admin['password']) { // Password check
                // Set session variables
                $_SESSION["login"] = true;
                $_SESSION["admin"] = true;
                $_SESSION["name"] = $admin['name'];
                $_SESSION["id"] = $admin['id'];

                // Redirect to admin dashboard
                header("Location: home.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Invalid email or account inactive.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2 class="text-center">Admin Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
</div>
</body>
</html>

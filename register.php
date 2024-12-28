<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

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
        <a class="navbar-brand" href="index.html">
            <i class="fas fa-hotel"></i> Hotel Management
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="home.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.html">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Register Form -->
<div class="form-container">
    <h2>Register</h2>
    <form action="../Users/PC/Documents/login.php" method="POST">
        <div class="mb-3">
            <label for="User name" class="form-label">user name</label>
            <input type="user name" id="user name" name="user name" class="form-control" placeholder="Enter your User name" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <div class="mb-3">
            <label for="Telephone" class="form-label">Telephone</label>
            <input type="Telephone" id="password" name="Telephone" class="form-control" placeholder="Enter your Telephone" required>
        </div>
        <div class="mb-3">
            <label for="Email" class="form-label">email</label>
            <input type="Email" id="Email" name="Email" class="form-control" placeholder="Enter your Email" required>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-custom"><i class="fas fa-sign-in-alt"></i> sign up</button>
            <a href="login.html"></a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
if($_POST["sign up"]==True)
{
// Collect form-data
$userName=$_POST["user Name"];
$password=$_POST["password"];
$Telephone=$_POST["Telephone"];
$Email=$_POST["Email"];
// Create connection
$conn = new mysqli("localhost", "root", "", "register");
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
// Insert Into The Table
$sql = "INSERT INTO register (userName, password, Telephone ,Email)
VALUES ('$userName', '$password', '$Telephone','$Email)";
if ($conn->query($sql) === TRUE) {
echo "New record created successfully";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
}
?>
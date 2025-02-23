<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Page</title>

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
            padding-top: 80px; /* For fixed navbar */
        }

        .form-container {
            background: rgba(248, 241, 241, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(15, 15, 15, 0.925);
            max-width: 700px;
            margin: auto;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-custom {
            border-radius: 10px;
            padding: 10px;
            font-size: 16px;
            width: 48%;
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

<!-- Room Form -->
<div class="form-container mt-5">
    <h2>Room Details</h2>
    <form action="../Users/PC/Documents/login.php" method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="Room number" class="form-label">Room number</label>
            <input type="number" id="Room number" name="Room number" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="Type of Room" class="form-label">Type of Room</label>
            <input type="text" id="Type of Room" name="type of room" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="price" class="form-label">price</label>
            <input type="number" id="price" name="price" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="Availabitity" class="form-label">Availabitity</label>
            <input type="text" id="Availabitity" name="Availabitity" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="Hotel ID" class="form-label">Hotel ID</label>
            <input type="number" id="Hotel ID" name="Hotel ID" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="Room space" class="form-label">Room space</label>
            <input type="number" id="Room space" name="room space" class="form-control" required>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex justify-content-between mt-4">
            <a href="index.php" class="btn btn-danger btn-custom"><i class="fas fa-arrow-left"></i> Back</a>
            <button type="submit" class="btn btn-success btn-custom"><i class="fas fa-check"></i> Next</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php
if($_POST["Next"]==True)
{
// Collect form-data
$Roomnumber=$_POST["Room number"];
$TypeofRoom=$_POST["Type of Room"];
$price=$_POST["price"];
$Availabitity=$_POST["Availabitity"];
$Roomspace=$_POST["Room space"];
// Create connection
$conn = new mysqli("localhost", "root", "", "room");
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
// Insert Into The Table
$sql = "INSERT INTO room (Roomnumber, TypeofRoom, price ,Availabitity,Room space)
VALUES ('$Roomnumber', '$TypeofRoom', '$price','$Availabitity','$Roomspace)";
if ($conn->query($sql) === TRUE) {
echo "New record created successfully";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
}
?>
<?php
include 'php/checkLogin.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>

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
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
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

<!-- Booking Form -->
<div class="form-container mt-5">
    <h2>Booking Details</h2>
    <form action="#" method="POST" class="row g-3">
<!--        <div class="col-md-6">-->
<!--            <label for="bookingID" class="form-label">Booking ID</label>-->
<!--            <input type="number" id="bookingID" name="bookingID" class="form-control" required>-->
<!--        </div>-->
<!--        <div class="col-md-6">-->
<!--            <label for="roomNumber" class="form-label">Room number</label>-->
<!--            <input type="number" id="roomNumber" name="roomNumber" class="form-control" required>-->
<!--        </div>-->
        <div class="col-md-6">
            <label for="checkIn" class="form-label">Check-in Date</label>
            <input type="date" id="checkIn" name="checkIn" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="checkOut" class="form-label">Check-out Date</label>
            <input type="date" id="checkOut" name="checkOut" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="guests" class="form-label">Number of Guests</label>
            <input type="number" id="guests" name="guests" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="totalPrice" class="form-label">Total Price</label>
            <input type="text" id="totalPrice" name="totalPrice" class="form-control" required>
        </div>
<!--        <div class="col-md-6">-->
<!--            <label for="bookingStatus" class="form-label">Booking Status</label>-->
<!--            <input type="text" id="bookingStatus" name="bookingStatus" class="form-control" required>-->
<!--        </div>-->
<!--        <div class="col-md-6">-->
<!--            <label for="createdDate" class="form-label">Created Date of Booking</label>-->
<!--            <input type="date" id="createdDate" name="createdDate" class="form-control" required>-->
<!--        </div>-->

        <div class="col-12 d-flex justify-content-between mt-4">
            <a href="index.php" class="btn btn-danger btn-custom"><i class="fas fa-arrow-left"></i> Back</a>
            <button type="submit" name="submitBooking" class="btn btn-success btn-custom"><i class="fas fa-check"></i> Booking</button>
        </div>
        <?php


if (isset($_POST['submitBooking'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel";

    // الاتصال بقاعدة البيانات
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);
        }

        // جمع بيانات النموذج
            session_start();



        $roomNumber = $_GET['id'];
        $customerID = $_SESSION['id'];
        $checkInDate = $_POST['checkIn'];
        $checkOutDate = $_POST['checkOut'];
        $numberOfGuests = $_POST['guests'];
        $totalPrice = $_POST['totalPrice'];
        $bookingStatus = "NEW";
        $createdDate = time();


        // إدخال البيانات في قاعدة البيانات
        $sql = "INSERT INTO booking (RoomNumber,CustomerID, CheckInDate, CheckOutDate, NumberOfGuests, TotalPrice, BookingStatus)
        VALUES ( '$roomNumber','$customerID', '$checkInDate', '$checkOutDate', '$numberOfGuests', '$totalPrice', '$bookingStatus')";


        if ($conn->query($sql) === TRUE) {
        echo "تم إنشاء الحجز بنجاح!";
        } else {
        echo "خطأ أثناء الحجز: " . $conn->error;
        }

        // إغلاق الاتصال
        $conn->close();
        }
        ?>

    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

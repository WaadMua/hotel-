<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Booking Form</title>

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
            padding-top: 80px; /* Adjust for navbar */
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
                <li class="nav-item">
                    <a class="nav-link" href="login.html">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Booking Form -->
<div class="form-container mt-5">
    <h2>Customer pay</h2>
    <form action="../Users/PC/Documents/login.php" method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="CustomerName" class="form-label">Customer Name</label>
            <input type="text" id="CustomerName" name="CustomerName" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="BookingID" class="form-label">Booking ID</label>
            <input type="text" id="BookingID" name="BookingID" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="HotelName" class="form-label">Hotel Name</label>
            <input type="text" id="HotelName" name="HotelName" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="RoomType" class="form-label">Room Type</label>
            <input type="text" id="RoomType" name="RoomType" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="CheckInDate" class="form-label">Check-in Date</label>
            <input type="date" id="CheckInDate" name="CheckInDate" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="CheckOutDate" class="form-label">Check-out Date</label>
            <input type="date" id="CheckOutDate" name="CheckOutDate" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="NumberOfNights" class="form-label">Number of Nights</label>
            <input type="number" id="NumberOfNights" name="NumberOfNights" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="NumberOfGuests" class="form-label">Number of Guests</label>
            <input type="number" id="NumberOfGuests" name="NumberOfGuests" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="TotalAmount" class="form-label">Total Amount</label>
            <input type="text" id="TotalAmount" name="TotalAmount" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="Pay" class="form-label">Pay</label>
            <select id='Pay'name='Pay'>
                <option value="Bankak">Bankak</option>
                <option value="Fawry">Fawry</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="AccountNumber" class="form-label">Account Number</label>
            <input type="text" id="AccountNumber" name="AccountNumber" class="form-control" required>
        </div>
        <div class="col-md-6"> 
            <label for="CurrencyType" class="form-label">Currency Type</label>
            <select id='CurrencyType'name='CurrencyType'>
                <option value="sudanese pound">sudanese pound</option>
                <option value="dollar">dollar</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex justify-content-between mt-4">
            <a href="index.php" class="btn btn-danger btn-custom"><i class="fas fa-home"></i> Exit</a>
            <button type="submit" class="btn btn-success btn-custom"><i class="fas fa-check"></i> pay</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php>
if($_POST["pay"]==True)
{
// Collect form-data
$CustomerName=$_POST["Customer Name"];
$BookingID=$_POST[" Booking ID"];
$HotelName=$_POST["Hotel Name"];
$RoomType=$_POST["Room Type"];
$CheckinDate=$_POST[" Check-in Date"];
$CheckoutDate=$_POST[" Check-out Date"];
$NumberofNights=$_POST[" Number of Nights"];
$NumberofGuests=$_POST[" Number of Guests"];
$TotalAmount=$_POST[" Total Amount"];
$Pay=$_POST[" Pay"];
$AccountNumber=$_POST[" Account Number"];
$CurrencyType=$_POST[" Currency Type"];
// Create connection
$conn = new mysqli("localhost", "root", "", "pay");
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
// Insert Into The Table
$sql = "INSERT INTO pay (CustomerName, Booking ID,HotelName,RoomType,CheckinDate,CheckoutDate,Numberof Nights,Numberof Guests,Total Amount,Pay,AccountNumber,CurrencyType)
VALUES ('$CustomerName', '$BookingID','$HotelName','$RoomType','$CheckinDate','$CheckoutDate','$NumberofNights','$NumberofGuests','$TotalAmount', '$Pay','$AccountNumber','$CurrencyType')";
if ($conn->query($sql) === TRUE) {
echo "New record created successfully";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
}
?>
<?php
include 'php/checkLogin.php';
session_start();

$roomId = $_GET['id'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// Get room price
$sql = "SELECT price FROM rooms WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $roomId);
$stmt->execute();
$result = $stmt->get_result();
$pricePerNight = 0;

if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();
    $pricePerNight = $room['price'];
} else {
    echo "<p class='text-danger'>Room not found.</p>";
}

$stmt->close();

// Get booked dates for the room
$bookedDates = [];
$sql = "SELECT CheckInDate, CheckOutDate FROM booking WHERE RoomNumber = ? AND BookingStatus != 'CANCELLED'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $roomId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $start = strtotime($row['CheckInDate']);
    $end = strtotime($row['CheckOutDate']);
    for ($date = $start; $date <= $end; $date += 86400) {
        $bookedDates[] = date("Y-m-d", $date);
    }
}

$stmt->close();
$conn->close();
?>

<!-- Pass booked dates to JavaScript -->
<script>
    const bookedDates = <?= json_encode($bookedDates); ?>;
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkIn = document.getElementById('checkIn');
        const checkOut = document.getElementById('checkOut');
        const totalPriceField = document.getElementById('totalPrice');
        const pricePerNight = <?= $pricePerNight; ?>;

        function disableBookedDates(input) {
            input.addEventListener('input', function () {
                if (bookedDates.includes(this.value)) {
                    alert("هذا التاريخ محجوز بالفعل، يرجى اختيار تاريخ آخر.");
                    this.value = "";
                }
            });
        }

        function calculatePrice() {
            const checkInDate = new Date(checkIn.value);
            const checkOutDate = new Date(checkOut.value);

            if (checkInDate && checkOutDate && checkOutDate > checkInDate) {
                const diffTime = Math.abs(checkOutDate - checkInDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                totalPriceField.value = diffDays * pricePerNight;
            } else {
                totalPriceField.value = 0;
            }
        }

        disableBookedDates(checkIn);
        disableBookedDates(checkOut);
        checkIn.addEventListener('change', calculatePrice);
        checkOut.addEventListener('change', calculatePrice);
    });
</script>


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
                    $userName = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8');
                    echo "<li class='nav-item'><a class='nav-link' href='php/logout.php'>$userName</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='mybookings.php'>My bookings</a></li>";
                } else {
                    echo "<li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Booking Form -->
<div class="form-container mt-5">
    <h2>Booking Details</h2>
    <?php
    $roomId = $_GET['id'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);
    }

    $sql = "SELECT price FROM rooms WHERE id = '$roomId'";
    $result = $conn->query($sql);
    $pricePerNight = 0;

    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
        $pricePerNight = $room['price'];
    } else {
        echo "<p class='text-danger'>Room not found.</p>";
    }

    $conn->close();
    ?>

    <form action="#" method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="checkIn" class="form-label">Check-in Date</label>
            <input type="date" id="checkIn" name="checkIn" class="form-control" required>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const checkIn = document.getElementById("checkIn");

                // Get today's date in YYYY-MM-DD format
                const today = new Date().toISOString().split("T")[0];

                // Set the minimum date to today to disable past dates
                checkIn.setAttribute("min", today);

                // Get booked dates from PHP
                const bookedDates = <?= json_encode($bookedDates); ?>;

                // Disable booked dates dynamically
                checkIn.addEventListener("focus", function () {
                    let options = checkIn.querySelectorAll("option");
                    options.forEach(option => {
                        if (bookedDates.includes(option.value)) {
                            option.disabled = true;
                        }
                    });
                });
            });
        </script>

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
            <input type="text" id="totalPrice" name="totalPrice" class="form-control" value="0" readonly>
        </div>

        <div class="col-12 d-flex justify-content-between mt-4">
            <a href="index.php" class="btn btn-danger btn-custom"><i class="fas fa-arrow-left"></i> Back</a>
            <button type="submit" name="submitBooking" class="btn btn-success btn-custom"><i class="fas fa-check"></i> Booking</button>
        </div>

        <?php
        if (isset($_POST['submitBooking'])) {
            $checkInDate = $_POST['checkIn'];
            $checkOutDate = $_POST['checkOut'];
            $numberOfGuests = $_POST['guests'];
            $totalPrice = $_POST['totalPrice'];
            $bookingStatus = "NEW";

            // Ensure check-in and check-out dates are valid
            if (strtotime($checkInDate) >= strtotime($checkOutDate)) {
                echo "<p class='text-danger'>خطأ: يجب أن يكون تاريخ المغادرة بعد تاريخ الوصول.</p>";
            } else {
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("فشل الاتصال: " . $conn->connect_error);
                }

                // Check if the room is already booked for the selected dates
                $sql = "SELECT * FROM booking WHERE RoomNumber = ? AND BookingStatus != 'CANCELLED' 
                AND ((CheckInDate BETWEEN ? AND ?) OR (CheckOutDate BETWEEN ? AND ?) 
                OR (? BETWEEN CheckInDate AND CheckOutDate) OR (? BETWEEN CheckInDate AND CheckOutDate))";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssss", $roomId, $checkInDate, $checkOutDate, $checkInDate, $checkOutDate, $checkInDate, $checkOutDate);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<p class='text-danger'>عذرًا، هذه الغرفة محجوزة بالفعل في هذه التواريخ. الرجاء اختيار تواريخ أخرى.</p>";
                } else {
                    // Insert booking if room is available
                    $sql = "INSERT INTO booking (RoomNumber, CustomerID, CheckInDate, CheckOutDate, NumberOfGuests, TotalPrice, BookingStatus) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("issssis", $roomId, $_SESSION['id'], $checkInDate, $checkOutDate, $numberOfGuests, $totalPrice, $bookingStatus);

                    if ($stmt->execute()) {
                        echo "<p class='text-success'>تم إنشاء الحجز بنجاح!</p>";
                    } else {
                        echo "<p class='text-danger'>خطأ أثناء الحجز: " . $stmt->error . "</p>";
                    }
                }

                $stmt->close();
                $conn->close();
            }
        }

        ?>

    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const checkIn = document.getElementById('checkIn');
    const checkOut = document.getElementById('checkOut');
    const totalPriceField = document.getElementById('totalPrice');
    const pricePerNight = <?= $pricePerNight; ?>;

    function calculatePrice() {
        const checkInDate = new Date(checkIn.value);
        const checkOutDate = new Date(checkOut.value);

        if (checkInDate && checkOutDate && checkOutDate > checkInDate) {
            const diffTime = Math.abs(checkOutDate - checkInDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            totalPriceField.value = diffDays * pricePerNight;
        } else {
            totalPriceField.value = 0;
        }
    }

    checkIn.addEventListener('change', calculatePrice);
    checkOut.addEventListener('change', calculatePrice);
</script>

</body>
</html>

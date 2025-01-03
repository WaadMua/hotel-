<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فندق أجنحة الصفوة</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <!--    <link rel="stylesheet" href="stylle.css">-->
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
                    echo "<li class='nav-item'>
        <a class='nav-link' href='mybookings.php'>My bookings</a>
    </li>";
                    $userName = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); // Escape session name for safety
                    echo "<li class='nav-item'>
        <a class='nav-link' href='php/logout.php'>$userName</a>
    </li>";

                } else {
                    echo "<li class='nav-item'>
        <a class='nav-link' href='index.php'>Login</a>
    </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>

<?php

$conn = new mysqli("localhost", "root", "", "hotel");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming customerID is passed via session or query parameter
$customerID = $_SESSION['id'] ?? 1; // Replace with session variable if needed

// Query to fetch booking data
$sql = "SELECT * FROM booking WHERE customerID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

echo '<section id="MyBooking" class="py-5">';
echo '<div class="container">';
echo '<h2 class="text-center mb-4">My Bookings</h2>';

if ($result->num_rows > 0) {
    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Room Number</th>';
    echo '<th>Check-In Date</th>';
    echo '<th>Check-Out Date</th>';
    echo '<th>Number of Guests</th>';
    echo '<th>Number of Days</th>';
    echo '<th>Total Price</th>';
    echo '<th>Booking Status</th>';
    echo '<th>Created Date</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Loop through each booking and display it
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['RoomNumber']) . '</td>';
        echo '<td>' . htmlspecialchars($row['CheckInDate']) . '</td>';
        echo '<td>' . htmlspecialchars($row['CheckOutDate']) . '</td>';
        echo '<td>' . htmlspecialchars($row['NumberOfGuests']) . '</td>';
        echo '<td>' . htmlspecialchars($row['NumberOfDays']) . '</td>';
        echo '<td>$' . htmlspecialchars($row['TotalPrice']) . '</td>';
        echo '<td>' . htmlspecialchars($row['BookingStatus']) . '</td>';
        echo '<td>' . date('Y-m-d', htmlspecialchars($row['CreatedDate'])) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<p class="text-center">No bookings found.</p>';
}

echo '</div>';
echo '</section>';

?>




<!-- Footer -->
<footer class="text-center p-3 bg-dark text-light">
    <p>جميع الحقوق محفوظة لموقع الفندق | كسلا السوق الكبير | رقم الهاتف: 249923100493</p>
    <p>البريد الإلكتروني: <a href="mailto:info@example.com" class="text-light">info@example.com</a></p>
</footer>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12N++dOn7V2mO9Kg4gq2B1GGAJpzzh4A5Z5/FOEl7P4iU9j7" crossorigin="anonymous"></script>
</body>
</html>
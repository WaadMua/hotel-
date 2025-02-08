<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all payments
$sql = "SELECT * FROM pay";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        .table th {
            background: #343a40;
            color: white;
        }
        .payment-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Hotel Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="display.php?table=customer">Customer</a></li>
                <li class="nav-item"><a class="nav-link" href="display.php?table=admin">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="display.php?table=hotel">Hotel</a></li>
                <li class="nav-item"><a class="nav-link" href="rooms/rooms.php">Rooms</a></li>
                <li class="nav-item"><a class="nav-link" href="booking/booking.php">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="pay.php">pay</a></li>
                <li class="nav-item"><a class="nav-link" href="../php/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="table-container">
        <h2 class="text-center mb-4">All Payments</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Booking Number</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Total Price</th>
                        <th>Payment Proof</th>
                        <th>Date Paid</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php $counter = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= htmlspecialchars($row['BookingNumber']) ?></td>
                            <td><?= htmlspecialchars($row['CheckInDate']) ?></td>
                            <td><?= htmlspecialchars($row['CheckOutDate']) ?></td>
                            <td>$<?= number_format($row['TotalPrice'], 2) ?></td>
                            <td>
                                <a href="uploads/<?= htmlspecialchars($row['Image']) ?>" target="_blank">
                                    <img src="uploads/<?= htmlspecialchars($row['Image']) ?>" class="payment-img" alt="">
                                </a>
                            </td>
                            <td><?= date('Y-m-d', strtotime($row['CreatedAt'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No payments found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>

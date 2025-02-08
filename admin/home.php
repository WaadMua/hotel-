<?php
session_start();


$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//Function to display data dynamically
function displayTable($conn, $tableName, $columns) {
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    echo "<div class='container'>";
    echo "<h3>" . ucfirst($tableName) . " Management</h3>";
    echo "<a href='add.php?table=$tableName' class='btn btn-success mb-3'>Add New</a>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr>";

    foreach ($columns as $column) {
        echo "<th>" . ucfirst($column) . "</th>";
    }
    echo "<th>Actions</th>";
    echo "</tr></thead>";
    echo "<tbody>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
            }
            echo "<td>";
            echo "<a href='edit.php?table=$tableName&id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
            echo "<a href='delete.php?table=$tableName&id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='" . (count($columns) + 1) . "' class='text-center'>No records found.</td></tr>";
    }

    echo "</tbody></table></div>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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



<div class="tab-content mt-4">
    <!-- Customer Section -->
    <div class="tab-pane fade show active" id="customer">
        <?php include 'crud.php'; displayTable($conn, 'customer', ['id', 'customer_name', 'customer_email', 'customer_phone']); ?>
    </div>

    <!-- Admin Section -->
    <div class="tab-pane fade" id="admin">
        <?php include 'crud.php'; displayTable($conn, 'admin', ['id', 'name', 'email', 'active']); ?>
    </div>

    <!-- Hotel Section -->
    <div class="tab-pane fade" id="hotel">
        <?php include 'crud.php'; displayTable($conn, 'hotel', ['id', 'Name', 'address']); ?>
    </div>

    <!-- Rooms Section -->
    <div class="tab-pane fade" id="rooms">
        <?php include 'crud.php'; displayTable($conn, 'rooms', ['id', 'title', 'price', 'hotel_ID']); ?>
    </div>

    <!-- Booking Section -->
    <div class="tab-pane fade" id="booking">
        <?php include 'crud.php'; displayTable($conn, 'booking', ['id', 'RoomNumber', 'customerID', 'CheckInDate', 'TotalPrice']); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

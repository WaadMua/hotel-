<?php
session_start();
require 'functions.php';

$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'] ?? null;

if (!$table) {
    echo "Invalid table name.";
    exit();
}

// Define columns for each table
$tableColumns = [
    'customer' => ['id', 'customer_name', 'customer_email', 'customer_phone'],
    'admin' => ['id', 'name', 'email', 'active'],
    'hotel' => ['id', 'Name', 'address'],
//    'rooms' => ['id', 'title', 'price', 'hotel_ID'],
    'booking' => ['id', 'RoomNumber', 'customerID', 'CheckInDate', 'TotalPrice']
];

if (!isset($tableColumns[$table])) {
    echo "Invalid table.";
    exit();
}

$columns = $tableColumns[$table];

?>

    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo ucfirst($table); ?> Management</title>
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

    <div class="container mt-5">
        <?php displayTable($conn, $table, $columns); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

<?php
$conn->close();
?>
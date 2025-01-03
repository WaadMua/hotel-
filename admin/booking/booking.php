<?php
session_start();

require "../../php/checkAdmin.php";

$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all rooms and customers
$rooms = $conn->query("SELECT id, title FROM rooms");
$customers = $conn->query("SELECT id, customer_name FROM customer");

// Fetch all bookings
$sql = "SELECT booking.*, rooms.title as room_title, customer.customer_name as customer_name
        FROM booking
        JOIN rooms ON booking.RoomNumber = rooms.id
        JOIN customer ON booking.customerID = customer.id
        ORDER BY booking.id ASC";
$result = $conn->query($sql);

$editing = false; // Flag to check if we are editing a booking
$editBooking = null; // Data for the booking being edited

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add') {
        // Add new booking
        $RoomNumber = $_POST['RoomNumber'];
        $customerID = $_POST['customerID'];
        $CheckInDate = $_POST['CheckInDate'];
        $CheckOutDate = $_POST['CheckOutDate'];
        $NumberOfGuests = $_POST['NumberOfGuests'];
        $TotalPrice = $_POST['TotalPrice'];
        $BookingStatus = $_POST['BookingStatus'];

        $sql = "INSERT INTO booking (RoomNumber, customerID, CheckInDate, CheckOutDate, NumberOfGuests, TotalPrice, BookingStatus)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissids", $RoomNumber, $customerID, $CheckInDate, $CheckOutDate, $NumberOfGuests, $TotalPrice, $BookingStatus);

        if ($stmt->execute()) {
            header("Location: booking.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } elseif ($action == 'delete') {
        // Delete booking
        $id = $_POST['id'];

        $sql = "DELETE FROM booking WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: booking.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } elseif ($action == 'edit') {
        // Load data for the booking to be edited
        $editing = true;
        $id = $_POST['id'];

        $editSql = "SELECT * FROM booking WHERE id = ?";
        $editStmt = $conn->prepare($editSql);
        $editStmt->bind_param("i", $id);
        $editStmt->execute();
        $editBooking = $editStmt->get_result()->fetch_assoc();
    } elseif ($action == 'update') {
        // Update booking
        $id = $_POST['id'];
        $RoomNumber = $_POST['RoomNumber'];
        $customerID = $_POST['customerID'];
        $CheckInDate = $_POST['CheckInDate'];
        $CheckOutDate = $_POST['CheckOutDate'];
        $NumberOfGuests = $_POST['NumberOfGuests'];
        $TotalPrice = $_POST['TotalPrice'];
        $BookingStatus = $_POST['BookingStatus'];

        $sql = "UPDATE booking SET RoomNumber = ?, customerID = ?, CheckInDate = ?, CheckOutDate = ?, NumberOfGuests = ?, TotalPrice = ?, BookingStatus = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissidsi", $RoomNumber, $customerID, $CheckInDate, $CheckOutDate, $NumberOfGuests, $TotalPrice, $BookingStatus, $id);

        if ($stmt->execute()) {
            header("Location: booking.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Hotel Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../display.php?table=customer">Customer</a></li>
                <li class="nav-item"><a class="nav-link" href="../display.php?table=admin">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="../display.php?table=hotel">Hotel</a></li>
                <li class="nav-item"><a class="nav-link" href="../rooms/rooms.php">Rooms</a></li>
                <li class="nav-item"><a class="nav-link active" href="booking.php">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="../../php/logout.php">Logout</a></li>

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Booking Management</h2>

    <!-- Add or Update Booking Form -->
    <form method="POST" class="mb-5">
        <h4><?php echo $editing ? "Update Booking" : "Add New Booking"; ?></h4>
        <div class="form-group">
            <label>Room</label>
            <select name="RoomNumber" class="form-control" required>
                <?php while ($row = $rooms->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo $editing && $editBooking['RoomNumber'] == $row['id'] ? 'selected' : ''; ?>>
                        <?php echo $row['title']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Customer</label>
            <select name="customerID" class="form-control" required>
                <?php while ($row = $customers->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo $editing && $editBooking['customerID'] == $row['id'] ? 'selected' : ''; ?>>
                        <?php echo $row['customer_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Check-In Date</label>
            <input type="date" name="CheckInDate" class="form-control" value="<?php echo $editing ? htmlspecialchars($editBooking['CheckInDate']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Check-Out Date</label>
            <input type="date" name="CheckOutDate" class="form-control" value="<?php echo $editing ? htmlspecialchars($editBooking['CheckOutDate']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Number of Guests</label>
            <input type="number" name="NumberOfGuests" class="form-control" value="<?php echo $editing ? htmlspecialchars($editBooking['NumberOfGuests']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Total Price</label>
            <input type="number" step="0.01" name="TotalPrice" class="form-control" value="<?php echo $editing ? htmlspecialchars($editBooking['TotalPrice']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Booking Status</label>
            <select name="BookingStatus" class="form-control" required>
                <option value="New" <?php echo $editing && $editBooking['BookingStatus'] == 'New' ? 'selected' : ''; ?>>New</option>
                <option value="Confirm" <?php echo $editing && $editBooking['BookingStatus'] == 'Confirm' ? 'selected' : ''; ?>>Confirm</option>
                <option value="Canceled" <?php echo $editing && $editBooking['BookingStatus'] == 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
            </select>
        </div>
        <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?php echo $editBooking['id']; ?>">
            <input type="hidden" name="action" value="update">
        <?php else: ?>
            <input type="hidden" name="action" value="add">
        <?php endif; ?>
        <button type="submit" class="btn btn-primary mt-3"><?php echo $editing ? "Update Booking" : "Add Booking"; ?></button>
    </form>

    <!-- Display Bookings -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Room</th>
            <th>Customer</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Guests</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['room_title']); ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['CheckInDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['CheckOutDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['NumberOfGuests']); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($row['TotalPrice'], 2)); ?></td>
                    <td><?php echo htmlspecialchars($row['BookingStatus']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="edit">
                            <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" class="text-center">No bookings found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>

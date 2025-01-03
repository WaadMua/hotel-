<?php
session_start();



$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all hotels for the dropdown
$hotels = $conn->query("SELECT id, Name FROM hotel");

// Fetch all rooms
$sql = "SELECT rooms.*, hotel.Name as hotel_name FROM rooms JOIN hotel ON rooms.hotel_ID = hotel.id ORDER BY rooms.id ASC";
$result = $conn->query($sql);

$editing = false; // Flag to check if editing mode is active
$editRoom = null; // Data for the room being edited

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add') {
        $title = $_POST['title'];
        $des = $_POST['des'];
        $price = $_POST['price'];
        $rate = $_POST['rate'];
        $hotel_ID = $_POST['hotel_ID'];

        $image = $_FILES['image']['name'];
        $targetDir = "../../Image/";
        $relativePath = "Image/" . basename($image);
        $target = $targetDir . basename($image);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $sql = "INSERT INTO rooms (title, des, price, rate, image, hotel_ID) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdisi", $title, $des, $price, $rate, $relativePath, $hotel_ID);

            if ($stmt->execute()) {
                header("Location: rooms.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Failed to upload file.";
        }
    } elseif ($action == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM rooms WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: rooms.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } elseif ($action == 'edit') {
        $editing = true;
        $id = $_POST['id'];

        $editSql = "SELECT * FROM rooms WHERE id = ?";
        $editStmt = $conn->prepare($editSql);
        $editStmt->bind_param("i", $id);
        $editStmt->execute();
        $editRoom = $editStmt->get_result()->fetch_assoc();
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $des = $_POST['des'];
        $price = $_POST['price'];
        $rate = $_POST['rate'];
        $hotel_ID = $_POST['hotel_ID'];

        $image = $_FILES['image']['name'];
        if ($image) {
            $targetDir = "../../Image/";
            $relativePath = "Image/" . basename($image);
            $target = $targetDir . basename($image);

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                echo "Failed to upload file.";
                exit();
            }
        } else {
            $relativePath = $_POST['current_image'];
        }

        $sql = "UPDATE rooms SET title = ?, des = ?, price = ?, rate = ?, image = ?, hotel_ID = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisii", $title, $des, $price, $rate, $relativePath, $hotel_ID, $id);

        if ($stmt->execute()) {
            header("Location: rooms.php");
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
    <title>Rooms Management</title>
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
                <li class="nav-item"><a class="nav-link active" href="rooms.php">Rooms</a></li>
                <li class="nav-item"><a class="nav-link" href="../display.php?table=booking">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="../../php/logout.php">Logout</a></li>

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Rooms Management</h2>

    <!-- Add or Update Room Form -->
    <form method="POST" enctype="multipart/form-data" class="mb-5">
        <h4><?php echo $editing ? "Update Room" : "Add New Room"; ?></h4>
        <div class="form-group">
            <label>Room Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $editing ? htmlspecialchars($editRoom['title']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="des" class="form-control" required><?php echo $editing ? htmlspecialchars($editRoom['des']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $editing ? htmlspecialchars($editRoom['price']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Rate</label>
            <input type="number" step="0.1" max="5" min="1" name="rate" class="form-control" value="<?php echo $editing ? htmlspecialchars($editRoom['rate']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Hotel</label>
            <select name="hotel_ID" class="form-control" required>
                <?php while ($row = $hotels->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo $editing && $editRoom['hotel_ID'] == $row['id'] ? 'selected' : ''; ?>>
                        <?php echo $row['Name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control-file">
            <?php if ($editing): ?>
                <small>Current: <?php echo htmlspecialchars($editRoom['image']); ?></small>
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($editRoom['image']); ?>">
            <?php endif; ?>
        </div>
        <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?php echo $editRoom['id']; ?>">
            <input type="hidden" name="action" value="update">
        <?php else: ?>
            <input type="hidden" name="action" value="add">
        <?php endif; ?>
        <button type="submit" class="btn btn-primary mt-3"><?php echo $editing ? "Update Room" : "Add Room"; ?></button>
    </form>

    <!-- Display Rooms -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Rate</th>
            <th>Image</th>
            <th>Hotel</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['des']); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($row['price'], 2)); ?></td>
                    <td><?php echo htmlspecialchars($row['rate']); ?>/5</td>
                    <td><img src="../../<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width: 100px; height: auto;"></td>
                    <td><?php echo htmlspecialchars($row['hotel_name']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="edit">
                            <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this room?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">No rooms found.</td>
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

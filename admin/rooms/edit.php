<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'];
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $des = $_POST['des'];
    $price = $_POST['price'];
    $rate = $_POST['rate'];
    $hotel_ID = $_POST['hotel_ID'];

    // Handle Image Upload
    $image = $_FILES['image']['name'];
    if ($image) {
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $sql = "UPDATE rooms SET title = ?, des = ?, price = ?, rate = ?, image = ?, hotel_ID = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisii", $title, $des, $price, $rate, $target, $hotel_ID, $id);
    } else {
        $sql = "UPDATE rooms SET title = ?, des = ?, price = ?, rate = ?, hotel_ID = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $title, $des, $price, $rate, $hotel_ID, $id);
    }

    if ($stmt->execute()) {
        header("Location: display.php?table=rooms");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch the existing record
$sql = "SELECT * FROM rooms WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

// Fetch all hotels for the dropdown
$hotels = $conn->query("SELECT id, Name FROM hotel");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Room</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Room Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($room['title']); ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="des" class="form-control" required><?php echo htmlspecialchars($room['des']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($room['price']); ?>" required>
        </div>
        <div class="form-group">
            <label>Rate</label>
            <input type="number" step="0.1" max="5" min="1" name="rate" class="form-control" value="<?php echo htmlspecialchars($room['rate']); ?>" required>
        </div>
        <div class="form-group">
            <label>Hotel</label>
            <select name="hotel_ID" class="form-control" required>
                <?php while ($row = $hotels->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo $room['hotel_ID'] == $row['id'] ? 'selected' : ''; ?>>
                        <?php echo $row['Name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control-file">
            <small>Current: <?php echo htmlspecialchars($room['image']); ?></small>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
    </form>
</div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>

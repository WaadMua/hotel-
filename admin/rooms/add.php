<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $des = $_POST['des'];
    $price = $_POST['price'];
    $rate = $_POST['rate'];
    $hotel_ID = $_POST['hotel_ID'];

    // Handle Image Upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $sql = "INSERT INTO rooms (title, des, price, rate, image, hotel_ID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdisi", $title, $des, $price, $rate, $target, $hotel_ID);

    if ($stmt->execute()) {
        header("Location: display.php?table=rooms");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch all hotels for the dropdown
$hotels = $conn->query("SELECT id, Name FROM hotel");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Room</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Room Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="des" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Rate</label>
            <input type="number" step="0.1" max="5" min="1" name="rate" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Hotel</label>
            <label>
                <select name="hotel_ID" class="form-control" required>
                    <?php while ($row = $hotels->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Add Room</button>
    </form>
</div>
</body>
</html>
<?php
$conn->close();
?>

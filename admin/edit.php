<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_GET['table'];
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = $_POST['fields'];

    $setFields = implode(", ", array_map(function ($key) {
        return "$key = ?";
    }, array_keys($fields)));

    $values = array_values($fields);
    $values[] = $id; // Add id for the WHERE clause

    $sql = "UPDATE $table SET $setFields WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($fields)) . "i", ...$values);

    if ($stmt->execute()) {
        header("Location: home.php#{$table}");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$sql = "SELECT * FROM $table WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Hotel Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link active" href="#customer" data-bs-toggle="tab">Customer</a></li>
                <li class="nav-item"><a class="nav-link" href="#admin" data-bs-toggle="tab">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="#hotel" data-bs-toggle="tab">Hotel</a></li>
                <li class="nav-item"><a class="nav-link" href="#rooms" data-bs-toggle="tab">Rooms</a></li>
                <li class="nav-item"><a class="nav-link" href="#booking" data-bs-toggle="tab">Booking</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Edit Record in <?php echo ucfirst($table); ?></h2>
    <form method="POST">
        <?php
        foreach ($record as $column => $value) {
            if ($column == 'id') continue;
            echo "<div class='form-group'>";
            echo "<label>" . ucfirst($column) . "</label>";
            echo "<input type='text' name='fields[$column]' class='form-control' value='" . htmlspecialchars($value) . "' required>";
            echo "</div>";
        }
        ?>
        <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
    </form>
</div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>

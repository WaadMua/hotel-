<?php
$conn = new mysqli("localhost", "root", "", "hotel");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST['table'];
    $fields = $_POST['fields'];

    $columns = implode(", ", array_keys($fields));
    $placeholders = implode(", ", array_fill(0, count($fields), "?"));
    $values = array_values($fields);

    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($fields)), ...$values);

    if ($stmt->execute()) {
        header("Location: home.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}

$table = $_GET['table'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Record to <?php echo ucfirst($table); ?></h2>
    <form method="POST">
        <input type="hidden" name="table" value="<?php echo $table; ?>">
        <?php
        $columns = $conn->query("SHOW COLUMNS FROM $table");
        while ($col = $columns->fetch_assoc()) {
            if ($col['Field'] == 'id') continue;
            echo "<div class='form-group'>";
            echo "<label>" . ucfirst($col['Field']) . "</label>";
            echo "<input type='text' name='fields[" . $col['Field'] . "]' class='form-control' required>";
            echo "</div>";
        }
        ?>
        <button type="submit" class="btn btn-primary mt-3">Add</button>
    </form>
</div>
</body>
</html>

<?php
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

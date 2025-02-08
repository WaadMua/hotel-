<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hotel");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingNumber = $_POST['bookingNumber'];
    $checkInDate = $_POST['checkInDate'];
    $checkOutDate = $_POST['checkOutDate'];
    $totalPrice = $_POST['totalPrice'];

    // File upload handling
    $targetDir = "uploads/";
    $fileName = basename($_FILES["proof"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $uploadError = $_FILES["proof"]["error"];

    // Debugging: Check if file was uploaded
    if ($uploadError > 0) {
        echo "<p class='text-danger'>File Upload Error Code: $uploadError</p>";
        switch ($uploadError) {
            case 1:
                echo "<p class='text-danger'>Error: The uploaded file exceeds the upload_max_filesize directive in php.ini.</p>";
                break;
            case 2:
                echo "<p class='text-danger'>Error: The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.</p>";
                break;
            case 3:
                echo "<p class='text-danger'>Error: The uploaded file was only partially uploaded.</p>";
                break;
            case 4:
                echo "<p class='text-danger'>Error: No file was uploaded.</p>";
                break;
            case 6:
                echo "<p class='text-danger'>Error: Missing a temporary folder.</p>";
                break;
            case 7:
                echo "<p class='text-danger'>Error: Failed to write file to disk.</p>";
                break;
            case 8:
                echo "<p class='text-danger'>Error: A PHP extension stopped the file upload.</p>";
                break;
            default:
                echo "<p class='text-danger'>Unknown upload error.</p>";
        }
        exit;
    }

    // Check if uploads directory is writable
    if (!is_dir($targetDir) || !is_writable($targetDir)) {
        echo "<p class='text-danger'>Error: The 'uploads/' directory is missing or not writable.</p>";
        exit;
    }

    // Allow only certain file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "<p class='text-danger'>Error: Only JPG, JPEG, PNG & GIF files are allowed.</p>";
        exit;
    }

    // Move uploaded file
    if (move_uploaded_file($_FILES["proof"]["tmp_name"], $targetFilePath)) {
        // Save to database
        $stmt = $conn->prepare("INSERT INTO pay (BookingNumber, CheckInDate, CheckOutDate, TotalPrice, Image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $bookingNumber, $checkInDate, $checkOutDate, $totalPrice, $fileName);

        if ($stmt->execute()) {
            echo "<script>alert('Payment proof uploaded successfully!'); window.location='index.php';</script>";
        } else {
            echo "<p class='text-danger'>Database error: Failed to save payment details.</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='text-danger'>Error: File upload failed. Please check directory permissions.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فندق أجنحة الصفوة</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <!--    <link rel="stylesheet" href="stylle.css">-->
</head>
<body>





<div class="container mt-5">
    <h2 class="text-center">Upload Payment Proof</h2>
    <form action="pay.php" method="post" enctype="multipart/form-data" class="p-4 shadow bg-white rounded">
        <input type="hidden" name="bookingNumber" value="<?= htmlspecialchars($_GET['booking'] ?? '') ?>">
        <input type="hidden" name="checkInDate" value="<?= htmlspecialchars($_GET['checkin'] ?? '') ?>">
        <input type="hidden" name="checkOutDate" value="<?= htmlspecialchars($_GET['checkout'] ?? '') ?>">
        <input type="hidden" name="totalPrice" value="<?= htmlspecialchars($_GET['price'] ?? '') ?>">

        <div class="mb-3">
            <label class="form-label">Upload Payment Proof (JPG, PNG, GIF)</label>
            <input type="file" class="form-control" name="proof" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Submit Payment</button>
    </form>
</div>
</body>
</html>

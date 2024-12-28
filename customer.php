<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: url('c.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-custom {
            border-radius: 10px;
            padding: 10px;
            font-size: 16px;
            width: 48%;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <i class="fas fa-hotel"></i> Hotel Management
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="home.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.html">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Form Section -->
<div class="form-container">
    <h2>Customer Details </h2>
    <form action="../Users/PC/Documents/login.php" method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="customer Name" class="form-label">Customer Name</label>
            <input type="text" id="customer Name" name="customer Name" class="form-control" placeholder="Enter Name" required>
        </div>

        <div class="col-md-6">
            <label for="customerEmail" class="form-label"> Customer Email</label>
            <input type="email" id="customer Email" name="customer Email" class="form-control" placeholder="Enter Email" required>
        </div>

        <div class="col-md-6">
            <label for="customer Address" class="form-label"> Customer Address</label>
            <input type="text" id="customer Address" name="customer Address" class="form-control" placeholder="Enter Address" required>
        </div>
        <div class="col-md-6">
            <label for="customer Phone" class="form-label"> Customer Phone</label>
            <input type="number" id="customer Phone" name="customer Phone" class="form-control" placeholder="Enter Phone" required>
        </div>

        <div class="col-md-6">
            <label for="customer Nationality" class="form-label"> Customer Nationality </label>
            <select id='customer Nationality'name='customer Nationality'>
            <option value="sudan">sudan</option>
            <option value="saudiArabia">saudiArabia</option>
            <option value="Egypt">Egypt</option>
            <option value="America">America</option>
            <option value="Ethiopia">Ethiopia</option>
        </select>
        </div>
        <div class="col-md-6">
            <label for="proof Of Identity" class="form-label">Proof of Identity</label>
            <input type="text" id="proof Of Identity" name="proof Of Identity" class="form-control" placeholder="Enter Proof" required>
        </div>

        <div class="col-12">
            <label for="customer Job" class="form-label">Customer Job</label>
            <input type="text" id="customer Job" name="customer Job" class="form-control" placeholder="Enter Job" required>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex justify-content-between mt-3">
            <a href="home.html" class="btn btn-danger btn-custom"><i class="fas fa-home"></i> Exit</a>
            <button type="submit" class="btn btn-success btn-custom"><i class="fas fa-arrow-right"></i> Next</button>
        </div>
    </form>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
if($_POST["Next"]==True)
{
// Collect form-data
$CustomerName=$_POST["Customer Name"];
$CustomerEmail=$_POST["Customer Email"];
$CustomerAddress=$_POST["Customer Address"];
$CustomerPhone=$_POST["Customer Phone"];
$CustomerNationality=$_POST["Customer Nationality"];
$ProofofIdentity=$_POST["Proof of Identity"];
$CustomerJob=$_POST["Customer Job"];
// Create connection
$conn = new mysqli("localhoste", "root", "", "Customer");
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
// Insert Into The Table
$sql = "INSERT INTO Customer (CustomerName, CustomerEmail, CustomerAddress ,CustomerPhone,CustomerNationality,ProofofIdentity,CustomerJob)
VALUES ('$CustomerName', '$CustomerEmail', '$CustomerAddress','$CustomerPhone','$CustomerNationality','$ProofofIdentity','$CustomerJob')";
if ($conn->query($sql) === TRUE) {
echo "New record created successfully";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
}
?>


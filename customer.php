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
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-hotel"></i> Hotel Management
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Contact</a>
                </li>
                <?php
                session_start();
                if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
                    $userName = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); // Escape session name for safety
                    echo "<li class='nav-item'>
        <a class='nav-link' href='php/logout.php'>$userName</a>
    </li>";
                    echo "<li class='nav-item'>
        <a class='nav-link' href='mybookings.php'>My bookings</a>
    </li>";
                } else {
                    echo "<li class='nav-item'>
        <a class='nav-link' href='login.php'>Login</a>
    </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Form Section -->
<div class="form-container">
    <h2>Customer Details </h2>
    <form action="#" method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="customer Name" class="form-label">Customer Name</label>
            <input type="text" id="customer Name" name="customerName" class="form-control" placeholder="Enter Name" required>
        </div>

        <div class="col-md-6">
            <label for="customerEmail" class="form-label"> Customer Email</label>
            <input type="email" id="customerEmail" name="customerEmail" class="form-control" placeholder="Enter Email" required>
        </div>

        <div class="col-md-6">
            <label for="customerPassword" class="form-label"> Customer Password</label>
            <input type="password" id="customerPassword" name="customerPassword" class="form-control" placeholder="Enter Email" required>
        </div>

        <div class="col-md-6">
            <label for="customer Address" class="form-label"> Customer Address</label>
            <input type="text" id="customer Address" name="customerAddress" class="form-control" placeholder="Enter Address" required>
        </div>
        <div class="col-md-6">
            <label for="customer Phone" class="form-label"> Customer Phone</label>
            <input type="number" id="customer Phone" name="customerPhone" class="form-control" placeholder="Enter Phone" required>
        </div>

        <div class="col-md-6">
            <label for="customer Nationality" class="form-label"> Customer Nationality </label>
            <br>
            <select id='customer Nationality'name='customerNationality' class="form-control">
            <option value="sudan">sudan</option>
            <option value="saudiArabia">saudiArabia</option>
            <option value="Egypt">Egypt</option>
            <option value="America">America</option>
            <option value="Ethiopia">Ethiopia</option>
        </select>
        </div>
        <div class="col-md-6">
            <label for="proof Of Identity" class="form-label">Proof of Identity</label>
            <input type="text" id="proof Of Identity" name="proofOfIdentity" class="form-control" placeholder="Enter Proof" required>
        </div>

        <div class="col-md-6">
            <label for="customer Nationality" class="form-label"> Identity Type </label>
            <br>
            <select id='customer Nationality' name='identityType' class="form-control">
                <option value="Identity Card">Identity Card</option>
                <option value="passport">Passport</option>
                <option value="Driver Listens">Driver Listens</option>


            </select>
        </div>

        <div class="col-12">
            <label for="customer Job" class="form-label">Customer Job</label>
            <input type="text" id="customer Job" name="customerJob" class="form-control" placeholder="Enter Job" required>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex justify-content-between mt-3">
            <a href="index.php" class="btn btn-danger btn-custom"><i class="fas fa-home"></i> Exit</a>
            <button type="submit" name="Next" class="btn btn-success btn-custom"><i class="fas fa-arrow-right"></i> Next</button>
        </div>

        <?php
        if (isset($_POST["Next"])) {
            // Collect form data
            $CustomerName = $_POST["customerName"];
            $CustomerEmail = $_POST["customerEmail"];
            $CustomerAddress = $_POST["customerAddress"];
            $CustomerPhone = $_POST["customerPhone"];
            $CustomerNationality = $_POST["customerNationality"];
            $ProofOfIdentity = $_POST["proofOfIdentity"];
            $IdentityType = $_POST["identityType"];
            $CustomerJob = $_POST["customerJob"];
            $CustomerPassword = $_POST["customerPassword"];

            // Create connection
            $conn = new mysqli("localhost", "root", "", "hotel");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Direct SQL query
            $sql = "INSERT INTO Customer (customer_name, customer_email,customer_password, customer_address, customer_phone, customer_nationality, proof_of_identity, identity_type, customer_job)
            VALUES ('$CustomerName', '$CustomerEmail','$CustomerPassword', '$CustomerAddress', '$CustomerPhone', '$CustomerNationality', '$ProofOfIdentity', '$IdentityType', '$CustomerJob')";

            // Execute query and check result
            if ($conn->query($sql) === TRUE) {
                echo  "<div class='alert alert-success' role='alert'>Registration successful!</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
            }

            $conn->close();
        }
        ?>
    </form>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




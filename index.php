<!doctype html>
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
                    <a class="nav-link" href="#About">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Room">Room</a>
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

<!-- Home Section with Bootstrap Carousel -->
<section id="Home">
    <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background: url('Image/r1.jpg.jpg') no-repeat center center/cover; height: 90vh;">
                <div class="carousel-caption">
                    <h3>Welcome to Our Hotel</h3>
                    <a href="#Room" class="btn btn-primary">Book Now</a>
                </div>
            </div>
            <div class="carousel-item" style="background: url('Image/r2.jpg.jpg') no-repeat center center/cover; height: 90vh;">
                <div class="carousel-caption">
                    <h3>Luxury Experience</h3>
                    <a href="#" class="btn btn-primary">Discover More</a>
                </div>
            </div>
            <div class="carousel-item" style="background: url('Image/r3.jpg.jpg') no-repeat center center/cover; height: 90vh;">
                <div class="carousel-caption">
                    <h3>Comfort and Elegance</h3>
                    <a href="#" class="btn btn-primary">Explore</a>
                </div>
            </div>
        </div>
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Room Section -->
<?php

$conn = new mysqli("localhost", "root", "", "hotel");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch room data
$sql = "SELECT rooms.*, hotel.name AS name 
        FROM rooms 
        JOIN hotel ON rooms.hotel_ID = hotel.id";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    echo '<section id="Room" class="py-5">';
    echo '<div class="container">';
    echo '<h2 class="text-center mb-4">Type of Room</h2>';
    echo '<div class="row">';

    // Loop through each room and display it
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card h-100 shadow-sm">';
        echo '<img src="' . htmlspecialchars($row['image']) . '" class="card-img-top" height="300" alt="' . htmlspecialchars($row['title']) . '">';
        echo '<div class="card-body text-center">';
        echo '<h3 class="card-title">' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p class="card-text">' . htmlspecialchars($row['des']) . '</p>';
        echo '<p class="card-text">Hotel: ' . htmlspecialchars($row['name']) . '</p>';
        echo '<p class="card-text">Price: $' . htmlspecialchars($row['price']) . ' / Night</p>';
        echo '<p>★★★★★ (' . htmlspecialchars($row['rate']) . ' / 5)</p>';
        echo '<a href="booking.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-success">Book Now</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
    echo '</section>';
} else {
    echo "<p>No rooms available.</p>";
}

?>

<!-- About Section -->
<section id="About" class="py-5 bg-light">
    <div class="container text-center">
        <h3>فندق أجنحة الصفوة - ولاية كسلا، السودان</h3>
        <p>
            فندق أجنحة الصفوة هو خيار مثالي للإقامة الفاخرة في قلب مدينة كسلا حيث يمتزج الراحة مع الفخامة في بيئة هادئة توفر للضيوف تجربة إقامة لا تُنسى.
        </p>
        <p>
            استمتع بتجربة إقامة لا تُنسى في فندق أجنحة الصفوة، حيث الفخامة والراحة في قلب ولاية كسلا.
        </p>
    </div>
</section>

<!-- Footer -->
<footer class="text-center p-3 bg-dark text-light">
    <p>جميع الحقوق محفوظة لموقع الفندق | كسلا السوق الكبير | رقم الهاتف: 249923100493</p>
    <p>البريد الإلكتروني: <a href="mailto:info@example.com" class="text-light">info@example.com</a></p>
</footer>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12N++dOn7V2mO9Kg4gq2B1GGAJpzzh4A5Z5/FOEl7P4iU9j7" crossorigin="anonymous"></script>
</body>
</html>

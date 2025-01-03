<?php
session_start();

if ($_SESSION['login'] == false) {
    echo "<script>
        alert('You are not logged in');
        window.location.href = 'http://localhost/hotel-/index.php';
    </script>";
    exit; // Always ensure you exit after a redirect or script execution
}
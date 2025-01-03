<?php
session_start();

if ($_SESSION["admin"] == false) {
    echo "<script>
        alert('You are not admin');
        window.location.href = 'http://localhost/hotel-/admin/index.php';
    </script>";
    exit; // Always ensure you exit after a redirect or script execution
}
<?php
session_start();

session_destroy();


$_SESSION = array();


echo "<script>
        window.location.href = 'http://localhost/hotel-/';
    </script>";
<?php
if (isset($_POST['submitBooking'])) {
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "hotel";

    // الاتصال بقاعدة البيانات
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);
    }

    // جمع بيانات النموذج
    $bookingID = $_POST['bookingID'];
    $roomNumber = $_POST['roomNumber'];
    $checkInDate = $_POST['checkIn'];
    $checkOutDate = $_POST['checkOut'];
    $numberOfGuests = $_POST['guests'];
    $totalPrice = $_POST['totalPrice'];
    $bookingStatus = $_POST['bookingStatus'];
    $createdDate = $_POST['createdDate'];
    $numberOfDays = $_POST['numberOfDays'];

    // إدخال البيانات في قاعدة البيانات
    $sql = "INSERT INTO booking (BookingID, RoomNumber, CheckInDate, CheckOutDate, NumberOfGuests, TotalPrice, BookingStatus, CreatedDate, NumberOfDays)
            VALUES ('$bookingID', '$roomNumber', '$checkInDate', '$checkOutDate', '$numberOfGuests', '$totalPrice', '$bookingStatus', '$createdDate', '$numberOfDays')";

    if ($conn->query($sql) === TRUE) {
        echo "تم إنشاء الحجز بنجاح!";
    } else {
        echo "خطأ أثناء الحجز: " . $conn->error;
    }

    // إغلاق الاتصال
    $conn->close();
}
?>

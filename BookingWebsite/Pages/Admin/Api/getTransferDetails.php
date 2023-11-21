<?php
include "./../../../Services/BookingStatus.php";
include './../../../Config/Connection.php';

$date = $_GET["date"];

$query = "SELECT * FROM payment JOIN booking USING(booking_id) WHERE booking_status='" . bookingStatus::COMPLETED->value . "' AND DATE(book_date) = DATE('$date')";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
  $response = array();
  while ($row = mysqli_fetch_assoc($result)) {
    array_push($response, $row);
  }
  echo json_encode($response);
  die();
}

echo json_encode([]);

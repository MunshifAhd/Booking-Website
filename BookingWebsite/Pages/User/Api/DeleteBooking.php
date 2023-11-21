<?php
include './../../../Config/Connection.php';
include './../../../Services/BookingStatus.php';

$bookingId = $_POST["bookingId"];
$query = "UPDATE booking SET booking_status='" . bookingStatus::CANCELLED->value . "' where booking_id='$bookingId'";

if (!mysqli_query($con, $query)) {
  echo json_encode(["success" => 0, "message" => "Failed to delete booking"]);
  die();
}

echo json_encode(["success" => 1, "message" => "Successfully deleted"]);

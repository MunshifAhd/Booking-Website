<?php
include "./../../../Config/Connection.php";
include "./../../../Services/BookingStatus.php";


$bookingId = $_POST["bookingId"];
$checked = $_POST["checked"];

if ($checked) {
  $query = "UPDATE booking SET booking_status='" . bookingStatus::CHECKED_IN->value . "' WHERE booking_id='$bookingId'";
}
if (!$checked) {
  $query = "UPDATE booking SET booking_status='" . bookingStatus::BOOKED->value . "' WHERE booking_id='$bookingId'";
}

if (mysqli_query($con, $query)) {
  echo json_encode(["success" => true, "message" => "updated successfully"]);
  die();
}

echo json_encode(["success" => false, "message" => "update failed"]);

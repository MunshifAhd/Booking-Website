<?php
function generateBookingId($con)
{
  define("BOOKINGIDPREFIX", "bk");
  define("BOOKINGIDLENGTH", 6);

  $query = "SELECT MAX(booking_id) AS booking_id FROM booking ORDER BY customer_id DESC LIMIT 1";
  $res = mysqli_query($con, $query);

  if (mysqli_num_rows($res) > 0) {
    $bookingId = mysqli_fetch_assoc($res)["booking_id"];
    $bookingIdNumPart = explode('-', $bookingId)[1];
    $bookingIdNumPart++;
    $bookingIdNumPart = str_pad($bookingIdNumPart, BOOKINGIDLENGTH, "0", STR_PAD_LEFT);
    return implode("-", [BOOKINGIDPREFIX,  $bookingIdNumPart]);
  }
  $bookingIdNumPart = str_pad("1", BOOKINGIDLENGTH, "0", STR_PAD_LEFT);
  return  implode("-", [BOOKINGIDPREFIX, $bookingIdNumPart]);
}

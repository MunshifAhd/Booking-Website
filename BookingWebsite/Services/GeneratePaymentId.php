<?php
function generatePaymentId($con)
{
  define("PAYMENTIDPREFIX", "p");
  define("PAYMENTIDLENGTH", 6);

  $query = "SELECT payment_id  FROM payment  ORDER BY payment_id DESC LIMIT 1";
  $res = mysqli_query($con, $query);

  if (mysqli_num_rows($res) > 0) {
    $paymentId = mysqli_fetch_assoc($res)["payment_id"];
    $paymentIdNumPart = explode('-', $paymentId)[1];
    $paymentIdNumPart++;
    $paymentIdNumPart = str_pad($paymentIdNumPart, PAYMENTIDLENGTH, "0", STR_PAD_LEFT);
    return implode("-", [PAYMENTIDPREFIX,  $paymentIdNumPart]);
  }
  $paymentIdNumPart = str_pad("1", PAYMENTIDLENGTH, "0", STR_PAD_LEFT);
  return  implode("-", [PAYMENTIDPREFIX, $paymentIdNumPart]);
}
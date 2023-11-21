<?php

function generateCustomerId($con)
{
  define("CUSIDPREFIX", "cus");
  define("CUSIDLENGTH", 6);

  $query = "
    SELECT
      customer_id
    FROM
      customer
    ORDER BY
      customer_id
    DESC
    LIMIT 1";

  $res = mysqli_query($con, $query);

  if (mysqli_num_rows($res) > 0) {
    $customerId = mysqli_fetch_assoc($res)["customer_id"];
    $customerIdNumPart = explode('-', $customerId)[1];
    $customerIdNumPart++;
    $customerIdNumPart = str_pad($customerIdNumPart, CUSIDLENGTH, "0", STR_PAD_LEFT);
    return implode("-", [CUSIDPREFIX,  $customerIdNumPart]);
  }
  $customerIdNumPart = str_pad("1", CUSIDLENGTH, "0", STR_PAD_LEFT);
  return  implode("-", [CUSIDPREFIX, $customerIdNumPart]);
}

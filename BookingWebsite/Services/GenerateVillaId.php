<?php
function generateVillaId($con)
{
  define("VILLA_ID_PREFIX", "villa");
  define("VILLA_ID_LENGTH", 2);

  $query = "SELECT villa_id  FROM villa ORDER BY villa_id DESC LIMIT 1";
  $res = mysqli_query($con, $query);

  if (mysqli_num_rows($res) > 0) {
    $villaId = mysqli_fetch_assoc($res)["villa_id"];
    $villaIdNumPart = explode('-', $villaId)[1];
    $villaIdNumPart++;
    $villaIdNumPart = str_pad($villaIdNumPart, VILLA_ID_LENGTH, "0", STR_PAD_LEFT);
    return implode("-", [VILLA_ID_PREFIX,  $villaIdNumPart]);
  }
  $villaIdNumPart = str_pad("1", VILLA_ID_LENGTH, "0", STR_PAD_LEFT);
  return  implode("-", [VILLA_ID_PREFIX, $villaIdNumPart]);
}

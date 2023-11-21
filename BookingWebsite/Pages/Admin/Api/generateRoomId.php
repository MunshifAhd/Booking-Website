<?php
include "./../../../Config/Connection.php";

define("ROOM_ID_PREFIX", "room");
define("ROOM_ID_NUMBER_PART_LENGTH", 2);

$branchId = $_POST["branchId"];
$branchName = $_POST["branchName"];

$query = "
  SELECT
    room_id,
    branch_name
  FROM
    room
  JOIN branch USING(branch_id)
  WHERE
    branch_id = '$branchId'
  ORDER BY
    room_id
  DESC
  LIMIT 1";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
  $roomId = mysqli_fetch_assoc($result)["room_id"];
  $roomIdNumPart = explode('-', $roomId)[2];
  $roomIdNumPart++;
  $roomIdNumPart = str_pad($roomIdNumPart, ROOM_ID_NUMBER_PART_LENGTH, "0", STR_PAD_LEFT);
} else {
  $roomIdNumPart = str_pad("1", ROOM_ID_NUMBER_PART_LENGTH, "0", STR_PAD_LEFT);
}

$roomId = implode("-", [ROOM_ID_PREFIX, $roomIdNumPart]);
$roomId = implode("-", [strtolower(str_split($branchName, 3)[0]), $roomId]);
echo $roomId;
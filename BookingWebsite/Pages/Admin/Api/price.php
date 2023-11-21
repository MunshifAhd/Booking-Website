<?php
include "./../../../Config/Connection.php";

$id = $_POST["id"];

if (isset($id)) {
  $query = "SELECT price FROM(SELECT room_id AS id,price FROM room UNION SELECT villa_id AS id,price FROM villa) AS roomsAndVillas WHERE id='$id'";

  $result = mysqli_query($con, $query);
  echo json_encode([mysqli_fetch_assoc($result)["price"]]);
}
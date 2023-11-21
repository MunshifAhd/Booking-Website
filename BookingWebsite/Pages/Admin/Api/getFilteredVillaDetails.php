<?php
include "./../../../Services/BookingStatus.php";
include './../../../Config/Connection.php';

$text = $_GET["searchText"];

$query = "SELECT v.*,br.branch_name,br.branch_id FROM villa AS v JOIN branch AS br USING(branch_id) WHERE br.branch_name LIKE CONCAT('$text','%')";
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

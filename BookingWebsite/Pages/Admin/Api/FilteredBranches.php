<?php
include "./../../../Config/Connection.php";

$textToSearch = $_POST['textToSearch'];
$query = "SELECT * From branch WHERE branch_name LIKE '$textToSearch%'";

$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
  $response = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $tempRow["id"] = $row["branch_id"];
    $tempRow["name"] = $row["branch_name"];
    $tempRow["desc"] = $row["branch_description"];
    $tempRow["phoneNo"] = $row["branch_phone_number"];
    array_push($response, $tempRow);
  }
  echo json_encode($response);
} else {
  echo json_encode([]);
}
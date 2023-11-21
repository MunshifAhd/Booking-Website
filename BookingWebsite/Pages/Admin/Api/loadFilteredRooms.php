<?php
include './../../../Config/Connection.php';

function addAndWhere($query)
{
  $query .= str_contains($query, "WHERE") ? " AND" : " WHERE";
  return $query;
}

$branchId = $_POST['branchId'];
$chkIn =  $_POST["chkIn"];
$chkOut =  $_POST["chkOut"];
$adults = $_POST["adults"];
$type = $_POST["type"];

$query = "
  SELECT
    id
  FROM
    (
    SELECT
      room_id AS id,
      price,
      description,
      title,
      img,
      occupancy,
      branch_id
    FROM
      room
    UNION
    SELECT
      villa_id AS id,
      price,
      description,
      title,
      img,
      occupancy,
      branch_id
    FROM
      villa
    ) AS roomsAndVillas";


if (!empty($type)) {
  if ($type == "Room") {
    $query = addAndWhere($query);
    $query .= " roomsAndVillas.id like '%room%'";
  }
  if ($type == "Villa") {
    $query = addAndWhere($query);
    $query .= " roomsAndVillas.id like '%villa%'";
  }
}

if (!empty($branchId)) {
  $query = addAndWhere($query);
  $query .= " branch_id='$branchId'";
}

if (!empty($adults)) {
  $query = addAndWhere($query);
  $query .= " occupancy>=$adults";
}

if (!empty($chkIn) && !empty($chkOut)) {
  $query = addAndWhere($query);

  $query .= " 
    id NOT IN(
      SELECT
      id
    FROM
      (
      SELECT
        room_id AS id,
        check_in,
        check_out
      FROM
        booking
      LEFT JOIN booking_room USING(booking_id)
      WHERE
        room_id IS NOT NULL
      UNION
      SELECT
        villa_id AS id,
        check_in,
        check_out
      FROM
        booking
      WHERE
      villa_id IS NOT NULL
      ) AS bk
    WHERE
      (
        bk.check_in <= '$chkIn' AND bk.check_out >= '$chkIn'
      ) OR(
        bk.check_in <= '$chkOut' AND bk.check_out >= '$chkOut'
      ) OR(
        bk.check_in >= '$chkIn' AND bk.check_out <= '$chkOut'
      ))";
}

$res = mysqli_query($con, $query);

if (mysqli_num_rows($res)) {
  $responseRes = array();
  while ($row = mysqli_fetch_assoc($res)) {
    array_push($responseRes, $row["id"]);
  }
  echo json_encode($responseRes);
  die();
}

echo json_encode([]);
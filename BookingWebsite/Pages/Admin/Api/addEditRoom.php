<?php
include "./../../../Config/Connection.php";

if (isset($_POST['btnAdd'])) {
  $target_dir = "Assets/Uploads/";
  $target_path = $target_dir . rand(0, 1000) . time() . basename($_FILES["img"]["name"]);

  $roomId = $_POST['roomId'];
  $title = trim($_POST['title']);
  $desc = trim($_POST['desc']);
  $noOfBeds = trim($_POST['noOfBeds']);
  $occupancy = trim($_POST['occupancy']);
  $price = trim($_POST['price']);
  $branchId = trim($_POST['branch']);

  move_uploaded_file($_FILES["img"]["tmp_name"], './../../../' . $target_path);

  $query = "
    INSERT INTO room(
      room_id,
      title,
      description,
      no_of_beds,
      occupancy,
      price,
      img,
      branch_id
    )
    VALUES(
      '$roomId',
      '$title',
      '$desc',
      $noOfBeds,
      $occupancy,
      $price,
      '$target_path',
     '$branchId'
    )
    ";

  if (mysqli_query($con, $query)) {
    echo "
    <script>
      alert('Room Added successfully');
      window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Failed to add room');
      window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  }
}

if (isset($_POST['btnEdit'])) {
  $roomId = $_POST['roomId'];
  $title = trim($_POST['title']);
  $desc = trim($_POST['desc']);
  $noOfBeds = trim($_POST['noOfBeds']);
  $occupancy = trim($_POST['occupancy']);
  $price = trim($_POST['price']);

  $query = "
    UPDATE
      room
    SET
      title = '$title',
      description = '$desc',
      no_of_beds = $noOfBeds,
      occupancy = $occupancy,
      price = $price
    WHERE
      room_id = '$roomId'";

  if (mysqli_query($con, $query)) {
    echo "
    <script>
      alert('Room Updated successfully');
      window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Failed to update room');
      window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  }
}

if (isset($_POST['btnDel'])) {
  $roomId = $_POST['roomId'];

  $query = "SELECT img FROM  room WHERE room_id='$roomId'";
  $result = mysqli_query($con, $query);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    unlink('./../../../' . $row["img"]);
  }

  $query = "DELETE FROM room WHERE room_id='$roomId'";

  if (mysqli_query($con, $query)) {
    echo "
    <script>
      alert('Room deleted successfully');
      window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Failed to delete room');
      window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  }
}
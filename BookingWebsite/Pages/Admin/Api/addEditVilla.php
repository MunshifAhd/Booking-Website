<?php
include "./../../../Config/Connection.php";

if (isset($_POST['btnAdd'])) {
  $target_dir = "Assets/Uploads/";
  $target_path = $target_dir . rand(0, 1000) . time() . basename($_FILES["img"]["name"]);

  $villaId = $_POST['villaId'];
  $title = trim($_POST['title']);
  $desc = trim($_POST['desc']);
  $noOfBeds = trim($_POST['noOfBeds']);
  $noOfRooms = trim($_POST['noOfRooms']);
  $occupancy = trim($_POST['occupancy']);
  $price = trim($_POST['price']);
  $branchId = trim($_POST['branch']);

  move_uploaded_file($_FILES["img"]["tmp_name"], './../../../' . $target_path);

  $query = "
    INSERT INTO villa(
      villa_id,
      title,
      description,
      no_of_beds,
      no_of_rooms,
      occupancy,
      price,
      img,
      branch_id
    )
    VALUES(
      '$villaId',
      '$title',
      '$desc',
        $noOfBeds,
        $noOfRooms,
        $occupancy,
        $price,
      '$target_path',
      '$branchId'
    )";

  if (mysqli_query($con, $query)) {
    echo "
    <script>
      alert('Villa Added successfully');
           window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Failed to add Villa');
           window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  }
}

if (isset($_POST['btnEdit'])) {
  $villaId = $_POST['villaId'];
  $title = trim($_POST['title']);
  $desc = trim($_POST['desc']);
  $noOfBeds = trim($_POST['noOfBeds']);
  $noOfRooms = trim($_POST['noOfRooms']);
  $occupancy = trim($_POST['occupancy']);
  $price = trim($_POST['price']);

  $query = "
    UPDATE
      villa
    SET
      title='$title',
      description='$desc',
      no_of_beds='$noOfBeds',
      no_of_rooms='$noOfRooms',
      occupancy='$occupancy',
      price='$price'
    WHERE
      villa_id='$villaId'";

  if (mysqli_query($con, $query)) {
    echo "
    <script>
      alert('Villa Updated successfully');
           window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Failed to update Villa'); 
         window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  }
}

if (isset($_POST['btnDel'])) {
  $villaId = $_POST['villaId'];

  $query = "SELECT img FROM  villa WHERE villa_id='$villaId'";
  $result = mysqli_query($con, $query);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    unlink('./../../../' . $row["img"]);
  }

  $query = "DELETE FROM villa WHERE villa_id='$villaId'";

  if (mysqli_query($con, $query)) {
    echo "
    <script>
      alert('Villa deleted successfully');
      window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  } else {
    echo "
    <script>
      history.back();
      alert('Failed to delete Villa');
      window.location='./../DashboardRoomsAndVillas.php';
    </script>";
  }
}

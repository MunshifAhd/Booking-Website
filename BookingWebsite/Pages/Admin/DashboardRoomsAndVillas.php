<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION["adminId"])) {
  header("Location:./AdminLogin.php");
  exit(401);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rooms And Villas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../index.css" />
  <style>
    .table-container {
      border-radius: 21px;
      background-color: var(--white);
      height: 200px;
      overflow-y: auto;
    }

    :is(.room-form, .villa-form) :is(.form-control, .form-select) {
      background-color: var(--white2);
      border: none;
    }

    .label-img {
      background-color: var(--white2);
      color: grey;
      border-radius: 5px;
      width: 250px;
      height: 120px;
      text-align: center;
      cursor: pointer;
    }

    .label-img:hover {
      box-shadow: 0 0 0 2px var(--img-overlay3);
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <?php include "./Components/Sidebar.php" ?>

    <section class="flex-grow-1 px-5 pt-4">
      <div class="d-flex align-items-center mb-5">
        <span class="fs-4 fw-semibold color-blue me-4" role="button" id="tabBtnRoom">Rooms</span>
        <span class="fs-4 fw-semibold color-blue" role="button" id="tabBtnVilla">Villa</span>
        <input class="form-control ms-auto me-3" style="max-width:250px" placeholder="Branch Name" id="searchBranchRoom" />
        <input class="form-control ms-auto me-3" style="max-width:250px; display: none" placeholder="Branch Name" id="searchBranchVilla" />
      </div>

      <!-- section room -->
      <section id="room">
        <div class="px-4 table-container">
          <table class="table" aria-label="room table" id="roomTable">
            <thead style="white-space: nowrap;">
              <tr>
                <th scope="col">Room ID</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">No of Beds</th>
                <th scope="col">Occupancy</th>
                <th scope="col">Price</th>
                <th scope="col">Branch</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include "./../../Config/Connection.php";

              $query = "SELECT r.*,br.branch_name,br.branch_id FROM room AS r JOIN branch AS br USING(branch_id) ";
              $result = mysqli_query($con, $query);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <tr data-id="<?php echo $row["room_id"]; ?>" data-title="<?php echo $row["title"]; ?>" data-description="<?php echo $row["description"]; ?>" data-beds="<?php echo $row["no_of_beds"]; ?>" data-occupancy="<?php echo $row["occupancy"]; ?> " data-price="<?php echo $row["price"]; ?>" data-img="<?php echo $row["img"]; ?>" data-branchid="<?php echo $row["branch_id"]; ?>">
                    <td class="ws-nowrap"><?php echo $row["room_id"]; ?></td>
                    <td><?php echo $row["title"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["no_of_beds"]; ?></td>
                    <td><?php echo $row["occupancy"]; ?></td>
                    <td><?php echo $row["price"]; ?></td>
                    <td><?php echo $row["branch_name"]; ?></td>
                  </tr>
                <?php
                }
              } else { ?>
                <tr style="pointer-events: none;">
                  <td colspan="10" class="text-center">
                    No Record Found
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <form class=" container-fluid ms-0 my-5 room-form" name="roomForm" method="POST" action="./Api/addEditRoom.php" enctype="multipart/form-data">
          <div class="d-flex">

            <div class="row g-3" style="flex-basis:60%;">
              <div class="col-5 fw-500 fs-6">
                <label>Room ID</label>
              </div>
              <div class="col-7">
                <input name="roomId" placeholder="Room ID" class="form-control" type="text" readonly />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Title</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="title" placeholder="Title" class="form-control" type="text" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Description</label>
              </div>
              <div class="col-7">
                <textarea autocomplete="off" required name="desc" placeholder="Description" class="form-control" style="resize:none;" rows="4"></textarea>
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>No of Beds</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="noOfBeds" placeholder="No of Beds" class="form-control" type="number" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Occupancy</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="occupancy" placeholder="Occupancy" class="form-control" type="number" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Price</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="price" placeholder="Price" class="form-control" type="text" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Branch</label>
              </div>
              <div class="col-7">
                <select name="branch" class="form-select">
                  <?php
                  $query = "SELECT branch_name,branch_id FROM branch";
                  $res = mysqli_query($con, $query);
                  if (mysqli_num_rows($res)) {
                    while ($row = mysqli_fetch_array($res)) { ?>

                      <option value="<?php echo $row["branch_id"] ?>">
                        <?php echo $row["branch_name"] ?>
                      </option>

                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

            </div>
            <div class="ms-auto" id="imgRoomContainer">
              <label for="imgUpload" class="d-flex align-items-center justify-content-center label-img">
                Image
              </label>
              <input type="file" name="img" accept="image/*" hidden id="imgUpload" />
            </div>
          </div>
          <div class="container-fluid mt-5">
            <div class="row">
              <div class="col-6"></div>
              <div class="col-2">
                <button name="btnAdd" class="btn w-100 btn-blue" type="submit">Add</button>
              </div>
              <div class="col-2">
                <button name="btnEdit" class="btn w-100 btn-green" type="submit">Edit</button>
              </div>
              <div class="col-2">
                <button name="btnDel" class="btn w-100 btn-red" type="submit">Delete</button>
              </div>
            </div>
          </div>
        </form>
      </section>


      <!-- section Villa -->
      <section id="villa" style="display: none">
        <div class="px-4 table-container">
          <table class="table" aria-label="Villa table" id="villaTable">
            <thead style="white-space: nowrap;">
              <tr>
                <th scope="col">Villa ID</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">No of Beds</th>
                <th scope="col">No of Rooms</th>
                <th scope="col">Occupancy</th>
                <th scope="col">Price</th>
                <th scope="col">Branch</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include "./../../Config/Connection.php";

              $query = "SELECT v.*,br.branch_name,br.branch_id FROM villa AS v JOIN branch AS br USING(branch_id) ";
              $result = mysqli_query($con, $query);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
              ?>

                  <tr data-id="<?php echo $row["villa_id"]; ?>" data-title="<?php echo $row["title"]; ?>" data-description="<?php echo $row["description"]; ?>" data-beds="<?php echo $row["no_of_beds"]; ?>" data-rooms="<?php echo $row["no_of_beds"]; ?>" data-occupancy="<?php echo $row["occupancy"]; ?> " data-price="<?php echo $row["price"]; ?>" data-img="<?php echo $row["img"]; ?>" data-branchid="<?php echo $row["branch_id"]; ?>">

                    <td><?php echo $row["villa_id"]; ?></td>
                    <td><?php echo $row["title"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["no_of_beds"]; ?></td>
                    <td><?php echo $row["no_of_rooms"]; ?></td>
                    <td><?php echo $row["occupancy"]; ?></td>
                    <td><?php echo $row["price"]; ?></td>
                    <td><?php echo $row["branch_name"]; ?></td>
                  </tr>

                <?php
                }
              } else { ?>
                <tr style="pointer-events: none;">
                  <td colspan="10" class="text-center">
                    No Record Found
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <form class="container-fluid ms-0 my-5 villa-form" name="villaForm" method="POST" action="./Api/addEditVilla.php" enctype="multipart/form-data">
          <div class="d-flex">

            <div class="row g-3" style="flex-basis:60%;">
              <div class="col-5 fw-500 fs-6">
                <label>Villa ID</label>
              </div>
              <div class="col-7">
                <input name="villaId" placeholder="Villa ID" class="form-control" type="text" readonly value="<?php include './../../Services/GenerateVillaId.php';
                                                                                                              echo generateVillaId($con); ?>" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Title</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="title" placeholder="Title" class="form-control" type="text" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Description</label>
              </div>
              <div class="col-7">
                <textarea autocomplete="off" required name="desc" placeholder="Description" class="form-control" style="resize:none;" rows="4"></textarea>
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>No of Beds</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="noOfBeds" placeholder="No of Beds" class="form-control" type="number" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>No of Rooms</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="noOfRooms" placeholder="No of Rooms" class="form-control" type="number" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Occupancy</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="occupancy" placeholder="Occupancy" class="form-control" type="number" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Price</label>
              </div>
              <div class="col-7">
                <input autocomplete="off" required name="price" placeholder="Price" class="form-control" type="text" />
              </div>

              <div class="col-5 fw-500 fs-6">
                <label>Branch</label>
              </div>
              <div class="col-7">
                <select name="branch" class="form-select">
                  <?php
                  $query = "SELECT branch_name,branch_id FROM branch";
                  $res = mysqli_query($con, $query);
                  if (mysqli_num_rows($res)) {
                    while ($row = mysqli_fetch_array($res)) { ?>

                      <option value="<?php echo $row["branch_id"] ?>">
                        <?php echo $row["branch_name"] ?>
                      </option>

                  <?php
                    }
                  }
                  ?>
                </select>
              </div>

            </div>
            <div class="ms-auto" id="imgVillaContainer">
              <label for="imgUploadVilla" class="d-flex align-items-center justify-content-center label-img">
                Image
              </label>
              <input type="file" name="img" accept="image/*" id="imgUploadVilla" hidden class="d-none" />
            </div>
          </div>
          <div class="container-fluid mt-5">
            <div class="row">
              <div class="col-6"></div>
              <div class="col-2">
                <button name="btnAdd" class="btn w-100 btn-blue" type="submit">Add</button>
              </div>
              <div class="col-2">
                <button name="btnEdit" class="btn w-100 btn-green" type="submit">Edit</button>
              </div>
              <div class="col-2">
                <button name="btnDel" class="btn w-100 btn-red" type="submit">Delete</button>
              </div>
            </div>
          </div>
        </form>
      </section>
        <?php include "./Components/footer.php" ?>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src='./Services/Js/DashboardRoomsAndVillas.js'></script>
</body>

</html>

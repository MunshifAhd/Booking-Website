<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link href="../../index.css" rel="stylesheet" />
  <link href="./Css/Booking.css" rel="stylesheet" />
</head>

<body>
  <?php include "../../Components/Header.php"; ?>

  <div class="img-random1-container position-relative">
    <img src="../../Assets/Random/random11.png" alt="" class="img-random1" />
    <div class="img-random1-overlay position-absolute top-0 d-flex align-items-center justify-content-center flex-column">
      <img src="../../Assets/logo2.png" alt="logo" style="width: 200px" />
    </div>
  </div>

  <?php include "../../Components/Filters.php"; ?>

  <section class="card-container mx-auto">
    <?php
    include "../../Config/Connection.php";

    $branch = isset($_SESSION["branch"]) ? $_SESSION["branch"] : null;
    $chkIn = isset($_SESSION["chkIn"]) ? $_SESSION["chkIn"] : null;
    $chkOut = isset($_SESSION["chkOut"]) ? $_SESSION["chkOut"] : null;
    $adults = isset($_SESSION["adults"]) ? $_SESSION["adults"] : null;
    $roomType = isset($_SESSION["roomType"]) ? $_SESSION["roomType"] : null;

    function addAndWhere($query)
    {
      $query .= str_contains($query, "WHERE") ? " AND" : " WHERE";
      return $query;
    }

    $query = "
      SELECT * from (SELECT
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
        villa) AS t1";

    if (isset($branch)) {
      $query .= " JOIN branch USING(branch_id)";
      $query = addAndWhere($query);
      $query .= " branch_name='" . $branch . "'";
    }

    if (isset($roomType)) {
      $query = addAndWhere($query);
      if ($roomType == "Room")  $query .= " t1.id like '%room%'";
      if ($roomType == "Villa")  $query .= " t1.id like '%villa%'";
    }

    if (isset($adults)) {
      $query = addAndWhere($query);
      $query .= " occupancy>='$adults'";
    }

    if (isset($chkIn, $chkOut)) {
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

    if (mysqli_num_rows($res) > 0) {
      while ($row = mysqli_fetch_assoc($res)) {
    ?>

        <div class="card mb-4">
          <div class="row g-0">
            <div class="col-md-3">
              <img src="./../../<?php echo $row["img"]; ?>" class="img-fluid rounded-start card-img" alt="..." width="500" style="object-fit: cover; height:100%;" />
            </div>

            <div class="col-md-9 p-4">
              <div class="card-body">
                <div class="d-flex gap-4">
                  <div class="mb-4" style="flex-grow: 1;">
                    <h6 class="fs-5 fw-semibold mb-3">
                      <?php echo $row["title"]; ?>
                    </h6>
                    <p class="fw-light mb-0">
                      <?php echo $row["description"]; ?>
                    </p>
                  </div>
                  <div class="card-price">
                    <h6 class="fs-6 fw-semibold">LKR
                      <?php echo number_format($row["price"], 2, ".", ",") ?>
                    </h6>
                    <p class="fs-7 fw-normal">Tax included</p>
                  </div>
                </div>
                <div class="d-flex justify-content-between" style="margin-top:auto;">
                  <button class="btn fw-semibold color-blue btn-view-info">View
                    info</button>
                  <a href="bookingConfirmation.php?id=<?php echo $row["id"] ?>">
                    <button class="btn btn-book-now px-4">Book Now</button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php
      }
    } else {
      ?>
      <h3 class="text-center fs-2">Sorry, No Rooms or Villas available</h3>
    <?php
    }
    ?>
  </section>

  <?php
  include "../../Components/MYCFooter.php";
  include "../../Components/Footer.php";
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
  </script>
</body>

</html>

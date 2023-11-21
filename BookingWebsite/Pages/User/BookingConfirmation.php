<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!empty($_GET["id"]) && empty($_SESSION["id"])) {
  $_SESSION["id"] = $_GET["id"];
}

if (empty($_GET["id"]) && empty($_SESSION["id"])) {
  header('Location:./booking.php');
  exit();
}

unset($_SESSION["branch"]);
unset($_SESSION["chkIn"]);
unset($_SESSION["chkOut"]);
unset($_SESSION["adults"]);
unset($_SESSION["roomType"]);
unset($_SESSION["room"]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Booking Confirmation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link href="../../index.css" rel="stylesheet" />
  <link href="./Css/BookingConfirmation.css" rel="stylesheet" />
</head>

<body>

  <?php
  include "./../../Components/Header.php";
  if (!isset($_SESSION["userId"])) {
  ?>
    <script>
      window.addEventListener('load', function() {
        alert("Please Login to proceed")
        window.location = "./Booking.php"
      })
    </script>
  <?php
  }
  ?>

  <div class="img-random1-container position-relative">
    <img src="../../Assets/Random/random11.png" alt="" class="img-random1" />
    <div class="img-random1-overlay position-absolute top-0 d-flex align-items-center justify-content-center flex-column">
      <img src="../../Assets/logo2.png" alt="logo" style="width: 200px" />
    </div>
  </div>

  <?php include "../../Components/Filters.php"; ?>

  <section class="main-container mx-auto">
    <?php
    include "../../Config/Connection.php";
    include "../../Services/IdPrefixes.php";

    $id = $_SESSION["id"];

    if (str_contains($id, prefixes::$Room->value))
      $query =  "SELECT  title, description, price,img FROM room WHERE room_id='$id' LIMIT 1";

    if (str_contains($id, prefixes::$Villa->value))
      $query =  "SELECT title, description, price,img  FROM villa WHERE villa_id='$id' LIMIT 1";

    $res = mysqli_query($con, $query);
    if (mysqli_num_rows($res) > 0) {
      $row = mysqli_fetch_assoc($res);
    ?>

      <div class="card mb-3">
        <div class="row g-0">
          <div class="col-md-3">
            <img src="./../../<?php echo $row["img"]; ?>" class="img-fluid rounded-start card-img" alt="..." width="500" style="object-fit: cover; height:100%;" />
          </div>
          <div class="col-md-9 p-4">
            <div class="card-body">
              <div class="d-flex gap-4">
                <div class="mb-4" style="flex-grow: 1;">
                  <h6 class="fs-5 fw-semibold mb-3">
                    <?php echo $row["title"]; ?></h6>
                  <p class="fw-light mb-0">
                    <?php echo $row["description"]; ?>
                  </p>
                </div>
                <div class="card-price">
                  <h6 class="fs-6 fw-semibold">
                    <?php echo number_format($row["price"], 2, ".", ",") ?>
                  </h6>
                  <p class="fs-7 fw-normal">Tax included</p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>



      <div class="book-conf-container p-5">
        <div class="d-flex justify-content-between mb-2">
          <div>
            <p class="d-inline fs-7 me-4 fw-500">Check-in</p>
            <p class="d-inline fs-6 color-blue fw-semibold me-5" id="chkIn">
              MM/DD/YYYY
            </p>

            <p class="d-inline fs-7 me-4 fw-500">Check-out</p>
            <p class="d-inline fs-6 color-blue fw-semibold me-5" id="chkOut">
              MM/DD/YYYY
            </p>

            <!-- <p class="d-inline fs-7 me-4 fw-500">Room</p>
          <p class="d-inline fs-6 color-blue fw-semibold me-5">2 Rooms</p> -->
          </div>

          <div>
            <p class="mb-0 fs-5 color-blue fw-semibold">LKR <?php echo number_format($row["price"], 2, ".", ",") ?></p>
            <p class="mb-0 fs-7 color-blue fw-500">Tax included</p>
          </div>
        </div>

        <h4 class="fs-4 fw-semibold color-blue mb-3">
          <?php echo $row["title"]; ?>
        </h4>
        <p class="fs-7 color-blue mb-4 fw-light">
          <?php echo $row["description"]; ?>
        </p>

      <?php
    }

    $query = "SELECT * FROM customer WHERE customer_id='" . $_SESSION['userId'] . "'";
    $res = mysqli_query($con, $query);
    if (mysqli_num_rows($res) > 0) {
      $rowCustomer = mysqli_fetch_assoc($res);
      ?>
        <form action="BookingConfirmation.php" method="post" name="bookingConfirmationForm" id="bookingConfirmationForm">
          <div class="row gx-4" style="max-width: 95%">
            <div class="col-6">
              <h4 class="fs-4 fw-semibold color-blue mb-5">Guest Details</h4>
              <div class="row g-3 align-items-center">
                <div class="col-6">
                  <label class="form-label">Guest Name</label>
                </div>
                <div class="col-6">
                  <input readonly value="<?php echo $rowCustomer['customer_name'] ?>" type="text" placeholder="Guest Name" name="guestName" class="form-control d-inline" required />
                </div>

                <div class="col-6">
                  <label class="form-label">Address</label>
                </div>
                <div class="col-6">
                  <input readonly value="<?php echo $rowCustomer['customer_address'] ?>" type="text" placeholder="Address" name="addr" class="form-control d-inline" required />
                </div>

                <div class="col-6">
                  <label class="form-label">NIC</label>
                </div>
                <div class="col-6">
                  <input readonly value="<?php echo $rowCustomer['customer_nic'] ?>" type="text" placeholder="NIC" name="nic" class="form-control d-inline" required />
                </div>

                <div class="col-6">
                  <label class="form-label">E-mail</label>
                </div>
                <div class="col-6">
                  <input readonly value="<?php echo $rowCustomer['customer_email'] ?>" type="email" placeholder="E-mail" name="email" class="form-control d-inline" required />
                </div>

                <div class="col-6">
                  <label class="form-label">Phone Number</label>
                </div>
                <div class="col-6">
                  <input readonly value="<?php echo $rowCustomer['customer_phone_number'] ?>" type="text" placeholder="Phone Number" name="phNo" class="form-control d-inline" required />
                </div>

                <div class="col-6">
                  <label class="form-label">Check In Date</label>
                </div>
                <div class="col-6">
                  <input type="date" name="chkIn" class="form-control d-inline" required />
                </div>

                <div class="col-6">
                  <label class="form-label">Check Out Date</label>
                </div>
                <div class="col-6">
                  <input type="date" name="chkOut" class="form-control d-inline" required />
                </div>

                <div class="col-6">
                  <label class="form-label">No of Occupants</label>
                </div>
                <div class="col-6">
                  <input type="number" name="noOfOccupants" placeholder="No of Occupants" class="form-control d-inline" required />
                </div>
              </div>
            </div>
            <div class="col-6">
              <h4 class="fs-4 fw-semibold color-blue mb-5">Payment Details</h4>
              <div class="row g-3 align-items-center">
                <div class="col-6">
                  <label class="form-label">Card Number</label>
                </div>
                <div class="col-6">
                  <input type="text" placeholder="Card Number" name="cardNo" class="form-control d-inline" inputmode="numeric" pattern="\d+" title="Should contain only digits" />
                </div>

                <div class="col-6">
                  <label class="form-label">Expiration Date</label>
                </div>
                <div class="col-6">
                  <input type="text" placeholder="MM/YYYY" class="form-control d-inline" name="cardExpiry" pattern="^\d{2}\/\d{4}$" title="MM/YYYY" />
                </div>

                <div class="col-6">
                  <label class="form-label">CVC Code</label>
                </div>
                <div class="col-2">
                  <input type="text" class="form-control d-inline" name="cvnCode" pattern="\d{3,4}" inputmode="numeric" />
                </div>
                <div class="col-2">
                  <img src="../../Assets/CVNCodeImg.png" alt="cvn image" />
                </div>
                <div class="col-6 fs-8 ms-auto">
                  This code is a three or four digit number printed on the back
                  or front of credit cards.
                </div>
              </div>
            </div>
          </div>
          <hr class="mt-5 mb-4" />
          <div class="ms-auto w-fit">
            <p class="fs-6 d-inline color-blue align-end fw-500">Total</p>
            <p class="fs-5 d-inline color-blue fw-semibold me-5 align-end">
              : LKR <?php echo number_format($row["price"], 2, ".", ",") ?>
            </p>
            <input type="hidden" name="paymentAmount" value="<?php echo $row["price"] ?>" />
            <button name="submit" class="btn btn-green px-4">Complete Book Now</button>
          </div>
        </form>

      <?php
    }
      ?>
      </div>
  </section>

  <?php
  include "../../Components/MYCFooter.php";
  include "../../Components/Footer.php";
  ?>

  <script src="./Services/Js/BookingConfirmation.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <?php
  if (isset($_POST["submit"])) {
    include "./../../Services/GenerateCustomerId.php";
    include "./../../Services/GenerateBookingId.php";
    include "./../../Services/GeneratePaymentId.php";
    include "./../../Services/BookingStatus.php";
    include "./../../Services/PaymentType.php";

    $chkIn = $_POST["chkIn"];
    $chkOut = $_POST["chkOut"];
    $noOfOccupants = $_POST["noOfOccupants"];
    $id = $_SESSION["id"];
    $customerId = $_SESSION["userId"];

    $paymentAmount = $_POST["paymentAmount"];

    $cardNo = $_POST["cardNo"];
    $cardExpiry = $_POST["cardExpiry"];
    $cvnCode = $_POST["cvnCode"];

    try {
      //check that room already booked or not
      $query = "
    SELECT
      DISTINCT id
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
      ) ";


      $results = mysqli_query($con, $query);

      if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_assoc($results)) {
          if ($row["id"] == $id) {
            echo "<script>alert('Sorry that room/villa is already booked on that date.');</script>";
            die();
          }
        }
      }

      //checking room capacity for entered occupants amount
      $query = "
    SELECT
    *
    FROM
        (
        SELECT
            room_id AS id,
            occupancy
        FROM
            room
        UNION
    SELECT
        villa_id AS id,
        occupancy
    FROM
        villa
    ) AS rooms_villas
    WHERE
      id = '$id' AND occupancy >= '$noOfOccupants'";

      $results = mysqli_query($con, $query);

      if (mysqli_num_rows($results) == 0) {
        echo "<script>alert('Sorry the selected room/villa not suitable for $noOfOccupants people.');</script>";
        die();
      }

      define("SUCCESS_MESSAGE", "<script>alert('Booked successfully');</script>");
      define("FAILURE_MESSAGE", "<script>alert('Something went wrong please try again.');</script>");

      if (
        !empty($chkIn) && !empty($chkOut) && !empty($noOfOccupants) && !empty($customerId) &&
        !empty($paymentAmount)
      ) {
        mysqli_query($con, "START TRANSACTION"); //start transaction
        $bookingID = generateBookingId($con);

        if (str_contains($id, prefixes::$Room->value)) {
          $query = "
          INSERT INTO booking(
            booking_id,
            check_in,
            check_out,
            no_of_occupants,
            booking_status,
            customer_id
          )
          VALUES(
            '$bookingID',
            '$chkIn',
            '$chkOut',
            '$noOfOccupants',
            '" . bookingStatus::$BOOKED->value . "',
            '$customerId'
          )";

          if (mysqli_query($con, $query) == 0) {
            mysqli_query($con, "ROLLBACK");
            echo FAILURE_MESSAGE;
            die();
          }

          //adding to booking_room table
          $query = "INSERT INTO booking_room VALUES ('$bookingID','$id')";
          if (mysqli_query($con, $query) == 0) {
            mysqli_query($con, "ROLLBACK");
            echo FAILURE_MESSAGE;
            die();
          }
        }

        if (str_contains($id, prefixes::$Villa->value)) {
          $query = "
            INSERT INTO booking(
              booking_id,
              check_in,
              check_out,
              no_of_occupants,
              booking_status,
              customer_id,
              villa_id
            )
            VALUES(
              '$bookingID',
              '$chkIn',
              '$chkOut',
              '$noOfOccupants',
              '" . bookingStatus::$BOOKED->value . "',
              '$customerId',
              '$id'
            )";

          if (mysqli_query($con, $query) == 0) {
            mysqli_query($con, "ROLLBACK");
            echo FAILURE_MESSAGE;
            die();
          }
        }

        if (empty($cardNo) && empty($cardExpiry) && empty($cvcCode)) {
          $paymentId = generatePaymentId($con);
          $query = "
          INSERT INTO payment(
            payment_id,
            payment,
            booking_id
          )
          VALUES('$paymentId',$paymentAmount, '$bookingID')";

          if (mysqli_query($con, $query) == 0) {
            mysqli_query($con, "ROLLBACK");
            echo FAILURE_MESSAGE;
            die();
          }

          mysqli_query($con, "COMMIT");
          echo SUCCESS_MESSAGE;
          die();
        }

        if (empty($cardNo) || empty($cardExpiry) || empty($cvnCode)) {
          mysqli_query($con, "ROLLBACK");
          echo "<script>alert('Booking failed missing some card details ')</script>";
          die();
        }

        $paymentId = generatePaymentId($con);
        $query = "
          INSERT INTO payment(
            payment_id,
            type,
            payment,
            creditcard_number,
            expiry,
            cvn,
            booking_id
          )
          VALUES('$paymentId', '" . paymentType::$CARD->value . "',$paymentAmount, '$cardNo', '$cardExpiry', '$cvnCode', '$bookingID')";

        if (mysqli_query($con, $query) == 0) {
          mysqli_query($con, "ROLLBACK");
          echo FAILURE_MESSAGE;
          die();
        }

        mysqli_query($con, "COMMIT");
        echo SUCCESS_MESSAGE;

        unset($_POST["submit"]);
      }
    } catch (Exception $e) {
      echo $e;
    }
  }
  ?>

</body>

</html>

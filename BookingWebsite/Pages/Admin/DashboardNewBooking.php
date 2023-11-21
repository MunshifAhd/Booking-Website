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
  <title>New Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../index.css" />
  <link rel="stylesheet" href="./Css/DashboardNewBooking.css" />
</head>

<body>
  <div class="d-flex">
    <?php include "./Components/Sidebar.php" ?>
    <form class="flex-grow-1 ps-5 pt-4" method="post" name="newBookingForm">
      <h4 class="fs-4 fw-semibold color-blue mb-5">New Booking</h4>
      <div class="d-flex">
        <div class="container-fluid" style="flex-basis:60%;margin-left:unset">
          <div class="row g-3">
            <div class="col-5">
              <select style='color:gray' class="form-select text-center fs-7" oninput='style.color="black"' name="branch" required>
                <option style="display:none;" selected value="">Branch
                </option>

                <?php
                include "./../../Config/Connection.php";
                include "./../../Services/CustomerType.php";


                $query = "SELECT branch_name,branch_id FROM branch";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_array($result)) {
                ?>

                    <option class="text-start" value="<?php echo $row[1] ?>" style="color:black">
                      <?php echo $row[0] ?>
                    </option>

                <?php
                  }
                }
                ?>

              </select>
            </div>

            <div class="w-100">
            </div>

            <div class="col-4">
              <input name="chkIn" class="form-control fs-7" placeholder="Check-in" type="text" onfocus="this.type='date'" onBlur="this.type='text'" required />
            </div>

            <div class="col-4">
              <input disabled name="chkOut" class="form-control fs-7" placeholder="Check-out" type="text" onfocus="this.type='date'" onBlur="this.type='text'" required />
            </div>


            <div class="w-100"></div>

            <div class="col-3">
              <select name="roomType" style='color:gray' class="form-select text-center fs-7" oninput='style.color="black"' required>
                <option hidden>Type</option>
                <option class="text-start" value="Villa" style="color:black">
                  Villa
                </option>
                <option class="text-start" value="Room" style="color:black">
                  Room</option>
              </select>
            </div>

            <div class="w-100"></div>

            <div class="col-2">
              <input name="adults" class="form-control " placeholder="Adults" type="number" min="1" />
            </div>

            <div class="w-100"></div>

            <div class="col-3">
              <select name="room" style='color:gray' class="form-select text-center fs-7" oninput='style.color="black"' required>
                <option hidden value="">Room/Villa</option>

                <?php
                $query = "SELECT id FROM(SELECT room_id AS id,branch_id FROM room UNION SELECT villa_id AS id,branch_id FROM villa) AS rooms_villas join branch USING(branch_id)";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_array($result)) {
                ?>

                    <option class="text-start text-black" value="<?php echo $row[0] ?>">
                      <?php echo $row[0] ?>
                    </option>

                <?php
                  }
                }
                ?>

              </select>
            </div>
          </div>
        </div>
        <div class="align-self-start me-5 d-flex">
          <span class="fs-4 fw-semibold color-blue" style="white-space: nowrap;">Total Amount : LKR&nbsp;
            <span id="totalAmountTemp">0.00</span>
          </span>
          <input type="hidden" value="0.00" name="paymentAmount" id="totalAmount">
        </div>

      </div>
      <div class="my-5">
        <div class="row gx-5 gy-3" style="max-width: 95%">
          <div class="col-6">
            <h4 class="fs-4 fw-semibold color-blue mb-5">Guest Details</h4>
          </div>

          <div class="col-6">
            <h4 class="fs-4 fw-semibold color-blue mb-5">Payment Details</h4>
          </div>

          <div class="col-3">
            <label class="form-label">Guest Name</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="Guest Name" name="guestName" class="form-control d-inline" required />
          </div>

          <div class="col-3">
            <label class="form-label">Card Number</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="Card Number" name="cardNo" class="form-control d-inline" inputmode="numeric" pattern="\d+" title="Should contain only digits" />
          </div>

          <div class="col-3">
            <label class="form-label">Address</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="Address" name="addr" class="form-control d-inline" required />
          </div>

          <div class="col-3">
            <label class="form-label">Expiration Date</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="MM/YYYY" class="form-control d-inline" name="cardExpiry" pattern="^\d{2}\/\d{4}$" title="MM/YYYY" />
          </div>

          <div class="col-3">
            <label class="form-label">NIC</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="NIC" name="nic" class="form-control d-inline" required />
          </div>

          <div class="col-3">
            <label class="form-label">CVC Code</label>
          </div>
          <div class="col-2">
            <input type="text" class="form-control d-inline" name="cvcCode" title="Should be 3-4 digit code" pattern="\d{3,4}" inputmode="numeric" />
          </div>
          <div class="col-1">
            <img src="../../Assets/CVNCodeImg.png" alt="cvc image" />
          </div>

          <div class="col-3">
            <label class="form-label">E-mail</label>
          </div>
          <div class="col-3">
            <input type="email" placeholder="E-mail" name="email" class="form-control d-inline" required />
          </div>

          <div class="col-3"></div>
          <div class="col-3 fs-8">
            This code is a three or four digit number printed on the back or
            front of credit cards.
          </div>

          <div class="col-3">
            <label class="form-label">Phone Number</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="Phone Number" name="phNo" class="form-control d-inline" required />
          </div>

          <div class="col-6"></div>
          <div class="col-3">
            <label class="form-label">Guest Type</label>
          </div>
          <div class="col-3">
            <select name="guestType" class="form-select text-center" required>
              <option class="text-start" value=<?php echo customerType::$single->value ?>>Single Customer</option>
              <option class="text-start" value=<?php echo customerType::$travelCompany->value ?>>Travel Company</option>
            </select>
          </div>

          <button name="submit" class="btn btn-green col-2 mx-auto">
            Book
          </button>
        </div>
      </div>
    </form>
  </div>


  <?php
  if (isset($_POST["submit"])) {
    include "./../../Services/GenerateCustomerId.php";
    include "./../../Services/GenerateBookingId.php";
    include "./../../Services/GeneratePaymentId.php";
    include "./../../Services/BookingStatus.php";
    include "./../../Services/PaymentType.php";

    $chkIn = $_POST["chkIn"];
    $chkOut = $_POST["chkOut"];
    $roomType = $_POST["roomType"];
    $adults = $_POST["adults"];
    $id = $_POST["room"];

    $guestName = $_POST["guestName"];
    $addr = $_POST["addr"];
    $nic = $_POST["nic"];
    $email = $_POST["email"];
    $phNo = $_POST["phNo"];
    $guestType = $_POST["guestType"];

    $cardNo = $_POST["cardNo"];
    $cardExpiry = $_POST["cardExpiry"];
    $cvcCode = $_POST["cvcCode"];
    $paymentAmount = $_POST["paymentAmount"];

    define("SUCCESS_MESSAGE", "<script>alert('Booked successfully');</script>");
    define("FAILURE_MESSAGE", "<script>alert('Something went wrong please try again.');</script>");

    if (empty($guestName) || empty($addr) || empty($nic) || empty($email) ||  empty($phNo) || empty($chkIn) || empty($chkOut) || empty($adults) ||  empty($id)) {
      echo FAILURE_MESSAGE;
      die();
    }

    $customerId = generateCustomerId($con);
    mysqli_query($con, "START TRANSACTION"); //Start Transaction.

    $query = "
        INSERT INTO customer(
          customer_id,
          customer_name,
          customer_email,
          customer_nic,
          customer_address,
          customer_phone_number,
          customer_type
        )
        VALUES(
          '$customerId',
          '$guestName',
          '$email',
          '$nic',
          '$addr',
          '$phNo',
          '$guestType'
        )";

    if (mysqli_query($con, $query) == 0) {
      mysqli_query($con, "ROLLBACK");
      echo FAILURE_MESSAGE;
      die();
    }

    $bookingID = generateBookingId($con);

    if ($roomType == "Room") {

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
            '$adults',
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

    if ($roomType == "Villa") {
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
          '$adults',
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

    if (empty($cardNo) || empty($cardExpiry) || empty($cvcCode)) {
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
      VALUES('$paymentId', '" . paymentType::$CARD->value . "',$paymentAmount, '$cardNo', '$cardExpiry', '$cvcCode', '$bookingID')";

    if (mysqli_query($con, $query) == 0) {
      mysqli_query($con, "ROLLBACK");
      echo FAILURE_MESSAGE;
      die();
    }

    mysqli_query($con, "COMMIT");
    echo SUCCESS_MESSAGE;
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="./Services/Js/DashboardNewBooking.js"></script>
</body>

</html>

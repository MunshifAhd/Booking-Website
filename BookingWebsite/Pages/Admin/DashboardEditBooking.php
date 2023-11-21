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
  <title>Document</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="../../index.css" />
  <link rel="stylesheet" href="./DashboardNewBooking.css" />
</head>

<body>
  <div class="d-flex">
    <?php include "./Components/Sidebar.php" ?>
    <form class="flex-grow-1 ps-5 pt-4" action="#" method="post"
      name="newBookingForm">
      <h4 class="fs-4 fw-semibold color-blue mb-5">New Booking</h4>
      <div class="d-flex">
        <div class="container-fluid" style="flex-basis:60%;margin-left:unset">
          <div class="row g-3">
            <div class="col-5">
              <select style='color:gray' class="form-select text-center fs-7"
                oninput='style.color="black"' name="branch" required>
                <option style="display:none;" selected>Branch
                </option>
                <?php
                include "./../../Config/Connection.php";
                $query = "SELECT branch_name,branch_id FROM branch";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_array($result)) {
                ?>

                <option class="text-start" value="<?php echo $row[0] ?>"
                  style="color:black" data-id="<?php echo $row[1] ?>">
                  <?php echo $row[0] ?>
                </option>

                <?php
                  }
                }
                ?>
              </select>
            </div>

            <div class=" w-100">
            </div>

            <div class="col-4">
              <input name="chkIn" class="form-control" placeholder="Check-in"
                type="text" onfocus="this.type='date'" onBlur="this.type='text'"
                required />
            </div>

            <div class="col-4">
              <input name="chkOut" class="form-control" placeholder="Check-out"
                type="text" onfocus="this.type='date'" onBlur="this.type='text'"
                required />
            </div>


            <div class="w-100"></div>

            <div class="col-3">
              <select name="roomType" style='color:gray'
                class="form-select text-center fs-7"
                oninput='style.color="black"' required>
                <option hidden>Type</option>
                <option class="text-start" value="Villa" style=" color:black">
                  Villa
                </option>
                <option class="text-start" value="Room" style=" color:black">
                  Room</option>
              </select>
            </div>

            <div class="w-100"></div>

            <div class="col-2">
              <input name="adults" class="form-control " placeholder="Adults"
                type="text" inputmode="numeric" pattern="[0-9]*"
                title="Only Numbers are allowed" />
            </div>

            <div class="w-100"></div>

            <div class="col-3">
              <select name="room" style='color:gray'
                class="form-select text-center fs-7"
                oninput='style.color="black"'>
                <option hidden>Room</option>
                <?php
                $query = "SELECT room_id,branch_id FROM room join branch USING(branch_id)";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_array($result)) {
                ?>

                <option class="text-start text-black"
                  value="<?php echo $row[0] ?>">
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
        <h4 class="fs-4 fw-semibold color-blue me-5"
          style="white-space: nowrap;" id="totalAmount">
          Total Amount : LKR </h4>

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
            <input type="text" placeholder="Guest Name" name="guestName"
              class="form-control d-inline" required />
          </div>

          <div class="col-3">
            <label class="form-label">Card Number</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="Card Number" name="cardNo"
              class="form-control d-inline" />
          </div>

          <div class="col-3">
            <label class="form-label">Address</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="Address" name="addr"
              class="form-control d-inline" required />
          </div>

          <div class="col-3">
            <label class="form-label">Expiration Date</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="MM/YYYY"
              class="form-control d-inline" name="cardExpiry" />
          </div>

          <div class="col-3">
            <label class="form-label">NIC</label>
          </div>
          <div class="col-3">
            <input type="text" placeholder="NIC" name="nic"
              class="form-control d-inline" required />
          </div>

          <div class="col-3">
            <label class="form-label">CVN Code</label>
          </div>
          <div class="col-2">
            <input type="text" class="form-control d-inline" name="cvnCode" />
          </div>
          <div class="col-1">
            <img src="../../Assets/CVNCodeImg.png" alt="cvn image" />
          </div>

          <div class="col-3">
            <label class="form-label">E-mail</label>
          </div>
          <div class="col-3">
            <input type="email" placeholder="E-mail" name="email"
              class="form-control d-inline" required />
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
            <input type="text" placeholder="Phone Number" name="phNo"
              class="form-control d-inline" required />
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

    // $branch = $_POST["branch"];
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

    $cardNo = $_POST["cardNo"];
    $cardExpiry = $_POST["cardExpiry"];
    $cvnCode = $_POST["cvnCode"];

    if (
      !empty($guestName) && !empty($addr) && !empty($nic) && !empty($email) &&
      !empty($phNo) && !empty($chkIn) && !empty($chkOut) && !empty($adults) &&  !empty($id)
    ) {
      $customerId = generateCustomerId($con);

      //start transaction
      mysqli_query($con, "START TRANSACTION");

      $query = "
    INSERT INTO customer(
      customer_id,
      customer_name,
      customer_email,
      customer_nic,
      customer_address,
      customer_phone_number
    )
    VALUES(
      '$customerId',
      '$guestName',
      '$email',
      '$nic',
      '$addr',
      '$phNo'
    )";

      if (mysqli_query($con, $query) == 0)
        mysqli_query($con, "ROLLBACK");

      else {

        $bookingID = generateBookingId($con);

        if (str_contains($id, "rm")) {
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
        'booked',
        '$customerId'
      )";
        }


        if (str_contains($id, "v")) {
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
          'booked',
          '$customerId',
          '$id'
        )";
        }

        if (mysqli_query($con, $query) > 0 && empty($cardNo) && empty($cardExpiry) && empty($cvnCode)) {
          if (str_contains($id, "v")) {
            mysqli_query($con, "COMMIT");
            echo "<script>alert('booked successfully')</script>";
          }
          if (str_contains($id, "rm")) {
            $query = "INSERT INTO booking_room VALUES ('$bookingID','$id')";
            if (mysqli_query($con, $query) > 0) {
              mysqli_query($con, "COMMIT");
              echo "<script>alert('booked successfully')</script>";
            } else {
              mysqli_query($con, "ROLLBACK");
              echo "<script>alert('booking failed some card details missing')</script>";
            }
          }
        } else {

          if (empty($cardNo) || empty($cardExpiry) || empty($cvnCode)) {
            mysqli_query($con, "ROLLBACK");
            echo "<script>alert('booking failed some card details missing')</script>";
          } else {
            $paymentId = generatePaymentId($con);
            $query = "
                    INSERT INTO payment(
                      payment_id,
                      type,
                      creditcard_number,
                      expiry,
                      cvn,
                      booking_id
                    )
                    VALUES('$paymentId', 'card', '$cardNo', '$cardExpiry', '$cvnCode', '$bookingID')";

            if (mysqli_query($con, $query) == 0) {
              mysqli_query($con, "ROLLBACK");
            } else {
              echo "<script>alert('booked successfully')</script>";
              mysqli_query($con, "COMMIT");
            }
          }
        }
      }
    }
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="./Services/Js/DashboardNewBooking.js"></script>
</body>

</html>
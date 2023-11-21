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
  <title>Manage Bookings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="./../../index.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <style>
    .form-check-input {
      width: 20px;
      height: 20px;
    }

    .form-check-label {
      user-select: none;
    }

    section#table {
      min-width: 0;
    }

    .table-container {
      border-radius: 21px;
      background-color: var(--white);
      height: 500px;
      overflow: auto;
    }

    .btn-green,
    .btn-green:is(:hover, :focus) {
      background-color: rgb(82, 171, 152);
    }

    .btn-red,
    .btn-red:is(:hover, :focus) {
      background-color: rgb(255, 114, 114);
    }

    .btn,
    .btn:is(:hover, :focus) {
      color: rgb(255, 255, 255);
      border: none;
      flex-basis: 50%;
    }

    .btn-container {
      transform: translateX(50px);
      gap: 1em;
      display: flex;
    }

    form .form-control,
    .form-select {
      background-color: var(--white2);
      border: none;
      border-radius: 5px;
    }

    form .form-control:hover,
    form .form-control:focus {
      background-color: var(--white2);
    }

    form .form-control::placeholder {
      text-align: center;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <?php include "./Components/Sidebar.php" ?>
    <section class="flex-grow-1 px-5 pt-4" id="table">
      <h4 class="fs-4 fw-semibold color-blue mb-5">Manage Booking</h4>
      <div class="px-4 table-container">
        <table class="table" aria-label="booking table">
          <thead style="white-space: nowrap;">
            <tr>
              <th scope="col">Booking ID</th>
              <th scope="col">Check In Date</th>
              <th scope="col">Check Out Date</th>
              <th scope="col">Booked Date</th>
              <th scope="col">Adults</th>
              <th scope="col">Status</th>
              <th scope="col">Villa ID</th>
              <th scope="col">Room ID</th>
              <th scope="col">Customer Name</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "../../Config/Connection.php";
            include "./../../Services/BookingStatus.php";

            $query = "SELECT bk.*,cus.customer_name,br.room_id FROM booking AS bk JOIN customer AS cus USING (customer_id) LEFT JOIN booking_room AS br USING(booking_id) WHERE booking_status='" . bookingStatus::$BOOKED->value . "'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="ws-nowrap" data-id="<?php echo $row["booking_id"]; ?>">
                  <td><?php echo $row["booking_id"]; ?></td>
                  <td><?php echo $row["check_in"]; ?></td>
                  <td><?php echo $row["check_out"]; ?></td>
                  <td><?php echo $row["book_date"]; ?></td>
                  <td><?php echo $row["no_of_occupants"]; ?></td>
                  <td><?php echo $row["booking_status"]; ?></td>
                  <td><?php echo $row["villa_id"]; ?></td>
                  <td><?php echo $row["room_id"]; ?></td>
                  <td><?php echo $row["customer_name"]; ?></td>
                </tr>
              <?php }
            } else {
              ?>
              <tr style="pointer-events: none;">
                <td colspan="4" class="text-center">No Records Found</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
  <?php include "./Components/footer.php" ?>
    </section>

    <section id="form" class="d-none">
      <span class="bi bi-x-circle-fill fs-1 float-end color-blue me-2 mt-2" role="button" id="closeBtn"></span>
      <form class="flex-grow-1 ps-5 pt-4" method="post" name="BookingForm">
        <h4 class="fs-4 fw-semibold color-blue mb-5">Manage Booking</h4>
        <div class="d-flex">
          <div class="container-fluid" style="flex-basis:60%;margin-left:unset">
            <div class="row g-3">
              <div class="col-5">
                <select class="form-select fs-7" name="branch" required>
                  <?php
                  include "./../../Config/Connection.php";
                  $query = "SELECT branch_name,branch_id FROM branch";
                  $result = mysqli_query($con, $query);
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                  ?>

                      <option value="<?php echo $row[0] ?>" data-id="<?php echo $row[1] ?>">
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
                <input name="chkIn" class="form-control fs-7" placeholder="Check-in" type="date" required />
              </div>

              <div class="col-4">
                <input name="chkOut" class="form-control fs-7" placeholder="Check-out" type="date" required />
              </div>


              <div class="w-100"></div>

              <div class="col-3">
                <select name="roomType" class="form-select fs-7" required>
                  <option class="text-start" value="Villa">Villa</option>
                  <option class="text-start" value="Room">Room</option>
                </select>
              </div>

              <div class="w-100"></div>

              <div class="col-2">
                <input name="adults" class="form-control " placeholder="Adults" type="text" inputmode="numeric" pattern="[0-9]*" title="Only Numbers are allowed" />
              </div>

              <div class="w-100"></div>

              <div class="col-3">
                <select name="room" class="form-select fs-7">
                  <?php
                  $query = "SELECT id FROM(SELECT room_id AS id,branch_id FROM room UNION SELECT villa_id AS id,branch_id FROM villa) AS rooms_villas join branch USING(branch_id)";
                  $result = mysqli_query($con, $query);
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                  ?>

                      <option value="<?php echo $row[0] ?>">
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
          <h4 class="fs-4 fw-semibold color-blue me-5" style="white-space: nowrap;" id="totalAmount">
            Total Amount : LKR 0.00 </h4>

        </div>
        <div class="my-5">
          <div class="row gx-5 gy-3" style="max-width: 95%">
            <div class="col-6">
              <h4 class="fs-4 fw-semibold color-blue mb-5">Guest Details</h4>
            </div>

            <div class="col-6 d-flex mb-5 align-items-start">
              <h4 class="fs-4 fw-semibold color-blue ">Payment Details</h4>
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
              <input type="text" placeholder="Card Number" name="cardNo" class="form-control d-inline" pattern="\d+" title="Should contain only digits" inputmode="numeric" />
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
              <input type="text" class="form-control d-inline" name="cvcCode" pattern="\d{3,4}" inputmode="numeric" />
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
                <option class="text-start" value="Single Customer">Single Customer</option>
                <option class="text-start" value="Travel Company">Travel Company</option>
              </select>
            </div>

            <div class="col-1"></div>

            <!-- hidden values -->
            <input type="hidden" hidden class="d-none" name="customerId" />
            <input type="hidden" hidden class="d-none" name="bookingId" />
            <input type="hidden" hidden class="d-none" name="paymentId" value="" />

            <div class="col-5 btn-container">
              <button name="submit" class="btn btn-green ms-auto">
                Update
              </button>

              <button name="delete" class="btn btn-red">
                Cancel Booking
              </button>
            </div>
          </div>
        </div>
      </form>
    </section>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="./Services/Js/DashboardManageBooking.js"></script>

  <?php
  define("FAILURE_MESSAGE", "<script>alert('Something went wrong please try again.');</script>");

  if (isset($_POST["submit"])) {
    include "./../../Services/GenerateCustomerId.php";
    include "./../../Services/GenerateBookingId.php";
    include "./../../Services/GeneratePaymentId.php";
    include "./../../Services/PaymentType.php";

    $bookingId = $_POST["bookingId"];
    $customerId = $_POST["customerId"];
    $paymentId = $_POST["paymentId"];

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

    $cardNo = isset($_POST["cardNo"]) ? $_POST["cardNo"] : null;
    $cardExpiry = isset($_POST["cardExpiry"]) ? $_POST["cardExpiry"] : null;
    $cvcCode = isset($_POST["cvcCode"]) ? $_POST["cvcCode"] : null;

    define("SUCCESS_MESSAGE", "<script>alert('Booking updated successfully.');</script>");

    if (empty($guestName) || empty($addr) || empty($nic) || empty($email) ||  empty($phNo) || empty($chkIn) || empty($chkOut) || empty($adults) ||  empty($id)) {
      echo FAILURE_MESSAGE;
      die();
    }

    //updating customer details
    $query = "
    UPDATE
      customer
    SET
      customer_name = '$guestName',
      customer_email = '$email',
      customer_nic = '$nic',
      customer_address = '$addr',
      customer_phone_number = '$phNo',
      customer_type = '$guestType'
    WHERE
      customer_id = '$customerId'";

    if (!mysqli_query($con, $query)) {
      echo FAILURE_MESSAGE;
      die("Failed to update customer");
    }

    //updating payment details
    if (!empty($cardNo) && !empty($cardExpiry) && !empty($cvcCode)) {
      $query = "
      UPDATE payment
      SET creditcard_number = '$cardNo',expiry = '$cardExpiry',cvn = '$cvcCode',type='" . paymentType::$CARD->value . "'
      WHERE payment_id = '$paymentId'";

      if (!mysqli_query($con, $query)) {
        echo FAILURE_MESSAGE;
        echo mysqli_error($con);
        die("Failed to update payment");
      }
    }

    echo SUCCESS_MESSAGE;
  }


  //delete
  if (isset($_POST["delete"])) {
    $bookingId = $_POST["bookingId"];

    if (empty($bookingId)) {
      echo FAILURE_MESSAGE;
      die("Booking Id not available");
    }

    $query = "DELETE FROM booking WHERE booking_id='$bookingId'";
    if (mysqli_query($con, $query)) {
      echo "<script>
        alert('Booking cancelled successfully.');
        window.location.href=window.location.href;
       </script>";
      exit();
    }

    echo FAILURE_MESSAGE;
    die("query error");
  }
  ?>
</body>

</html>

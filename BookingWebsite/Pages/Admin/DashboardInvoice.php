<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION["adminId"])) {
  header("Location:./AdminLogin.php");
  exit(401);
}


if (isset($_POST["submit"])) {
  include("./../../Config/Connection.php");
  include("./../../Services/BookingStatus.php");

  define("FAILURE_MESSAGE", "<script>alert('Something went wrong please try again.');</script>");
  define("SUCCESS_MESSAGE", "<script>alert('Successfully completed the invoice.');</script>");

  $additionalCharges = $_POST["additionalCharges"];
  $paymentId = $_POST["paymentId"];
  $bookingId = $_POST["bookingId"];
  $payType = $_POST["payType"];

  $query1 = "UPDATE booking SET booking_status='" . bookingStatus::$COMPLETED->value . "' WHERE booking_id='$bookingId'";
  $query2 = "UPDATE payment SET addition=$additionalCharges,type='$payType',date='" . date("Y/m/d") . "' WHERE payment_id='$paymentId'";

  if (mysqli_query($con, "START TRANSACTION")) {
    if (!mysqli_query($con, $query1) || !mysqli_query($con, $query2)) {
      echo FAILURE_MESSAGE;
      echo "<script>window.location.href=window.location.href</script>";
      mysqli_query($con, "ROLLBACK");
      die("query error");
    }
    mysqli_query($con, "COMMIT");
    echo SUCCESS_MESSAGE;
    echo "<script>window.location.href=window.location.href</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="./../../index.css" />
  <style>
    .table-container {
      border-radius: 21px;
      background-color: var(--white);
      height: 200px;
      overflow: auto;
    }

    .form-control {
      background-color: #EDEDED;
      border: none;
      border-radius: 4px;
    }
  </style>
</head>

<body>
  <div class="d-flex " style="max-width: 100vw;">
    <?php include "./Components/Sidebar.php" ?>
    <section class="flex-grow-1 px-5 py-4" style="min-width: 0;">

      <div class="d-flex align-items-center mb-5">
        <h4 class="fs-4 fw-semibold color-blue">Invoice</h4>
        <input class="form-control ms-auto me-4" style="max-width:250px" placeholder="Branch Name" id="searchBranch" />
      </div>

      <div class="px-4 table-container">
        <table class="table" aria-label="booking Table" id="bookingTable">
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

            $query = "
              SELECT
                bk.*,
                cus.customer_name,
                bk_room.room_id
              FROM
                booking AS bk
              JOIN customer AS cus USING(customer_id)
              LEFT JOIN booking_room AS bk_room USING(booking_id) WHERE booking_status='" . bookingStatus::$CHECKED_IN->value . "'";

            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="ws-nowrap" data-booking_id=<?php echo $row["booking_id"] ?>>
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
                <td colspan="9" class="text-center">No Records Found</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>

      <div class="d-none mt-5 gap-5 pe-5" id="bookingDetails">
        <section style="flex-basis: 55%;">
          <div class="container-fluid mb-4">
            <div class="row g-4 text-start" style="white-space: nowrap;">
              <div class="col-6 p-0">
                <p class="fw-semibold fs-6 m-0">Check-in</p>
              </div>
              <div class="col-6 p-0">
                <span class="color-blue" id="chkInDate">Thu 11 Aug 22</span>
              </div>
              <div class="col-6 p-0">
                <p class="fw-semibold fs-6 m-0">Check-out</p>
              </div>
              <div class="col-6 p-0">
                <span class="color-blue" id="chkOutDate">Sat 13 Aug 22 </span>
              </div>
            </div>
          </div>

          <div>
            <h5 class="color-blue fw-semibold fs-5 mb-3" id="title">
            </h5>
            <p class="color-blue fs-7 m-0 mb-3" id="desc">
            </p>

            <!-- <p class="mb-4 fw-500 fs-7">
              Room <span class="color-blue">2 Rooms</span>
            </p> -->
          </div>


          <h5 class="color-blue fw-semibold fs-5 mb-3">Guest Details </h5>
          <div class="container-fluid mb-4">
            <div class="row gy-2">
              <div class="col-6 fw-500 fs-7 p-0 color-blue">Guest Name</div>
              <div class="col-6 fw-500 fs-7 p-0" id="name"></div>
              <div class="col-6 fw-500 fs-7 p-0 color-blue">Address</div>
              <div class="col-6 fw-500 fs-7 p-0" id="addr">
              </div>
              <div class="col-6 fw-500 fs-7 p-0 color-blue">NIC</div>
              <div class="col-6 fw-500 fs-7 p-0" id="noc"></div>
              <div class="col-6 fw-500 fs-7 p-0 color-blue">Phone Number</div>
              <div class="col-6 fw-500 fs-7 p-0" id="pNo"></div>
            </div>
          </div>

          <div id="paymentSection" class="d-none">
            <h5 class="color-blue fw-semibold fs-5 mb-3">Payment Details</h5>
            <div class="container-fluid">
              <div class="row">
                <div class="col-6 fw-500 fs-7 p-0 color-blue">Card
                  Number
                </div>
                <div class="col-6 p-0 fw-500 fs-7" id="cardNo"><span></span>
                </div>
              </div>
            </div>
          </div>

        </section>

        <form style="flex-basis: 45%;" name="invoiceForm" method="post">
          <h5 class="color-blue fw-semibold fs-5 mb-5">Additional Charge</h5>

          <div class="container-fluid">
            <div class="row gy-3">

              <div class="col-6 p-0 fw-500 fs-7">
                <label for="restaurantBills" class="col-form-label">Restaurant
                  Bills</label>
              </div>

              <div class="col-6 p-0">
                <input type="text" name="restaurantBills" id="restaurantBills" class="form-control" pattern="\d+(.\d{0,2})?" title="eg: 12/12.00">
              </div>


              <div class="col-6 p-0 fw-500 fs-7">
                <label for="swimmingPool">Swimming Pool</label>
              </div>
              <div class="col-6 p-0">
                <input type="text" name="swimmingPool" id="swimmingPool" class="form-control" pattern="\d+(.\d{0,2})?" title="eg: 12/12.00">
              </div>

              <div class="col-6 p-0 fw-500 fs-7">
                <label for="meals">Meals</label>
              </div>
              <div class="col-6 p-0">
                <input type="text" name="meals" id="meals" class="form-control" pattern="\d+(.\d{0,2})?" title="eg: 12/12.00">
              </div>

              <div class="col-6 p-0 fw-500 fs-7">
                <label for="ek">Extra Keys</label>
              </div>
              <div class="col-6 p-0">
                <input type="text" name="extraKeys" id="ek" class="form-control" pattern="\d+(.\d{0,2})?" title="eg: 12/12.00">
              </div>

              <div class="col-6 p-0 fw-500 fs-7">
                <label for="ts">Telephone Service</label>
              </div>
              <div class="col-6 p-0">
                <input type="text" name="telephoneService" id="ts" class="form-control" pattern="\d+(.\d{0,2})?" title="eg: 12/12.00">
              </div>

              <div class="col-6 p-0 fw-500 fs-7">
                <label for="cs">Club Service</label>
              </div>
              <div class="col-6 p-0">
                <input type="text" name="clubService" id="cs" class="form-control" pattern="\d+(.\d{0,2})?" title="eg: 12/12.00">
              </div>

              <div class="col-6 p-0 fw-500 fs-7">
                Payment
              </div>
              <div class="col-2 p-0 fs-7">
                <label class="form-radio-label d-flex">
                  Cash
                  <input type="radio" class="ms-1 form-radio-input" name="payType" value="CASH" required>
                </label>
              </div>
              <div class="col-1"></div>
              <div class="col-2 p-0 fs-7">
                <label class="form-radio-label d-flex">
                  Card
                  <input type="radio" class="ms-1 form-radio-input" name="payType" value="CARD" required>
                </label>
              </div>
            </div>
          </div>

          <div class="ms-auto w-fit text-end mt-4">
            <p class="color-blue fs-6">
              Sub Total :
              <span class="fw-semibold">
                LKR
                <span id="subTotal">
                  7500.00
                </span>
              </span>
            </p>
            <p class="color-blue fs-6">
              Additional Charges :
              <span class="fw-semibold">
                LKR
                <span id="additionalCharges">
                  0000.00
                </span>
              </span>
            </p>
            <p class="color-blue fs-6">Grand Total :<span class="fw-semibold">
                LKR
                <span id="grandTotal">
                  7500.00
                </span>
              </span>
            </p>

            <button class="mt-2 btn px-4" style="background-color: #52AB98;color: white;" type="submit" name="submit">Complete Invoice</button>
          </div>

          <!-- hidden fields -->
          <input type="hidden" name="additionalCharges" class="d-none" value="0">
          <input type="hidden" name="paymentId" class="d-none">
          <input type="hidden" name="bookingId" class="d-none">

        </form>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="./Services/Js/DashboardInvoice.js" type="module"></script>
</body>

</html>

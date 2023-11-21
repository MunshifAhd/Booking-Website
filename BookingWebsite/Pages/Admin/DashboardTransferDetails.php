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
  <title>Transfer Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../index.css" />
  <style>
    .table-container {
      border-radius: 21px;
      background-color: var(--white);
      min-height: 400px;
      overflow: auto;
    }

    .btn-print,
    .btn-print:is(:hover, :focus) {
      background-color: #52AB98;
      color: white;
      padding-left: 4rem;
      padding-right: 4rem;
      border: none;
    }
  </style>
</head>

<body>
  <div class="d-flex mw-100">
    <?php include "./Components/Sidebar.php" ?>
    <section class="flex-grow-1 px-5 pt-4 flex-shrink-1" style="min-width: 0;">
      <div class="d-flex align-items-center mb-5">
        <h4 class="fs-4 fw-semibold color-blue ">Transfer Details</h4>
        <input type="date" id="filterByDate" class="form-control w-fit ms-auto me-4" />
      </div>
      <div class="px-4 table-container mw-100">
        <table class="table" aria-label="Payment table" id="paymentTable">
          <thead style="white-space: nowrap;">
            <tr>
              <th scope="col">Payment ID</th>
              <th scope="col">Type</th>
              <th scope="col">Date</th>
              <th scope="col">Addition</th>
              <th scope="col">Payment</th>
              <th scope="col">Credit Card Number</th>
              <th scope="col">Expiry</th>
              <th scope="col">CVC Code</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "../../Config/Connection.php";
            include "./../../Services/BookingStatus.php";

            $query = "SELECT * FROM payment JOIN booking USING(booking_id) WHERE booking_status='" . bookingStatus::$COMPLETED->value . "'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                  <td><?php echo $row["payment_id"]; ?></td>
                  <td><?php echo $row["type"]; ?></td>
                  <td><?php echo $row["date"]; ?></td>
                  <td><?php echo $row["addition"]; ?></td>
                  <td><?php echo $row["payment"]; ?></td>
                  <td><?php echo $row["creditcard_number"]; ?></td>
                  <td><?php echo $row["expiry"]; ?></td>
                  <td><?php echo $row["cvn"]; ?></td>
                </tr>
              <?php }
            } else {
              ?>
              <tr>
                <td colspan="8" class="text-center">No Records Found</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <button class="mt-5 ms-auto d-table btn btn-print" id="btnPrint">Print</button>
    </section>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="./Services/Js/DashboardTransferDetails.js"></script>
</body>

</html>

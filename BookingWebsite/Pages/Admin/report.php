<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reports</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="../../index.css" />
  <link rel="stylesheet" href="../DashboardHome.css" />
  <link rel="stylesheet" href="./Css/report.css" />
</head>

<body>
  <div class="d-flex">
    <?php include "./Components/Sidebar.php" ?>
    <section class="flex-grow-1 ps-5 pt-4">
      <h6 class="fs-5 mont mb-4">Generate Reports</h6>
      <div class="container">
        <div class="row">
          <div class="col-4 mt-5">
            <a href="Rep_Booking.php" target="_blank">
            <button class="w-100 btn btn-danger me-3" >Past Bookings</button>
          </a>
          </div>
          <div class="col-4 mt-5">
            <a href="Rep_Future_booking.php" target="_blank">
            <button class="w-100 btn btn-danger me-3">Future Bookings</button>
                  </a>
          </div>
          <div class="col-4 mt-5">
            <a href="Financial_report.php" target="_blank">
            <button class="w-100 btn btn-danger me-3" >Financial Information</button>
          </a>
          </div>

        </div>
      </div>
    </section>

  </div>
</body>

</html>

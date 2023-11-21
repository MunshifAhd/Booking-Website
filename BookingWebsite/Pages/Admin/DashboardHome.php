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
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../index.css" />
  <link rel="stylesheet" href="./Css/DashboardHome.css" />
</head>

<body>
  <div class="d-flex">
    <?php include "./Components/Sidebar.php" ?>
    <section class="flex-grow-1 px-5 pt-4 main">
      <h6 class="fs-5 mont mb-4">Dashboard</h6>
      <p style="color:green">Welcome to the Wings Hotels!</p>
      <div class="container">
        <div class="row">
          <div class="col-2">
            <button class="w-100 btn btn-success me-3">Notifications</button>
          </div>
          <div class="col-2">
            <a href="./DashboardNewBooking.php">
              <button class="w-100 btn btn-danger">Booking</button>
            </a>
          </div>
        </div>
      </div>
      <div class="px-4 table-container mt-4">
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
              <th scope="col">Checked In</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "./../../Config/Connection.php";
            include "./../../Services/BookingStatus.php";

            $query = "
              SELECT
                bk.*,
                cus.customer_name,
                br.room_id
              FROM
                booking AS bk
                JOIN customer AS cus USING (customer_id)
                LEFT JOIN booking_room AS br USING(booking_id)
              WHERE
                booking_status IN('" . bookingStatus::$BOOKED->value . "','" . bookingStatus::$CHECKED_IN->value . "')";

            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="ws-nowrap">
                  <td><?php echo $row["booking_id"]; ?></td>
                  <td><?php echo $row["check_in"]; ?></td>
                  <td><?php echo $row["check_out"]; ?></td>
                  <td><?php echo $row["book_date"]; ?></td>
                  <td><?php echo $row["no_of_occupants"]; ?></td>
                  <td><?php echo $row["booking_status"]; ?></td>
                  <td><?php echo $row["villa_id"]; ?></td>
                  <td><?php echo $row["room_id"]; ?></td>
                  <td><?php echo $row["customer_name"]; ?></td>
                  <td class="text-center position-relative">
                    <div class="form-check form-switch position-absolute top-50 start-50 translate-middle">
                      <input data-bookingid="<?php echo $row["booking_id"]; ?>" class="form-check-input" type="checkbox" <?php echo $row["booking_status"] === bookingStatus::$CHECKED_IN->value ? "checked" : ""; ?>>
                    </div>
                  </td>
                </tr>
              <?php }
            } else { ?>
              <tr>
                <td colspan="10" class="text-center">
                  <h5 class="fs-5 mont fw-semibold">
                    No Record Found
                  </h5>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    <?php include "./Components/footer.php" ?>

      </footer>
    </section>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    const bookingStatusTogglers = Array.from(document.querySelectorAll('.form-check-input'));
    bookingStatusTogglers.forEach(toggler => {
      toggler.addEventListener('change', async function() {
        const bookingId = this.dataset.bookingid;

        const formData = new FormData();
        formData.set("bookingId", bookingId);
        formData.set("checked", this.checked ? 1 : 0);

        try {
          const {
            data: {
              success,
              message
            }
          } = await axios.post(`./Api/toggleBookingStatus.php`, formData);

          if (success) {
            window.location.reload();
            return
          }

          alert(message);

        } catch (error) {

        }

      })
    })
  </script>
</body>

</html>

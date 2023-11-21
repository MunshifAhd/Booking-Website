<?php
if (session_status() === PHP_SESSION_NONE)
  session_start();

if (!isset($_SESSION["userId"])) {
  header("Location:./home.php");
  exit(401);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Bookings</title>
  <link href="./../../index.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <style>
    .table-container {
      border-radius: 21px;
      background-color: var(--white);
      min-height: 400px;
      overflow: auto;
      max-width: 80%;
    }

    .icon-btn {
      padding: 5px;
      padding-inline: 10px;
      transition: all 100ms ease-in-out;
    }

    .icon-btn:hover {
      box-shadow: inset 0 0 0 20px rgb(0 0 0 /.1);
    }

    .icon-btn:active {
      box-shadow: inset 0 0 0 20px rgb(0 0 0 /.3), 0 0 0 5px rgb(0 0 0 /.3);
    }
  </style>
</head>

<body>

  <?php
  include "./../../Components/Header.php"; ?>

  <div class="px-4 table-container mt-5 mx-auto">
    <table class="table" aria-label="Payment table" id="paymentTable">
      <thead class="ws-nowrap">
        <tr>
          <th scope="col">Booking ID</th>
          <th scope="col">Check In Date</th>
          <th scope="col">Check Out Date</th>
          <th scope="col">Booked Date</th>
          <th scope="col">Adults</th>
          <th scope="col">Status</th>
          <th scope="col">Villa ID</th>
          <th scope="col">Room ID</th>
          <th scope="col">Cancel Booking</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include "../../Config/Connection.php";
        include "./../../Config/Connection.php";
        include "./../../Services/BookingStatus.php";

        $userId = $_SESSION["userId"];
        $query = "SELECT * FROM booking Left JOIN booking_room USING(booking_id) WHERE customer_id='$userId' AND booking_status='" . bookingStatus::BOOKED->value . "'";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));

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
              <td class="text-center position-relative">
                <span id="<?php echo $row["booking_id"]; ?>" class="icon-btn text-danger rounded-circle bi bi-trash-fill position-absolute start-50 top-50 translate-middle" role="button">
                </span>
              </td>
            </tr>
          <?php   }
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
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    document.querySelectorAll('.icon-btn').forEach(iconBtn => {
      iconBtn.addEventListener('click', async function() {
        const formData = new FormData();
        formData.append('bookingId', this.id)

        let {
          data: response
        } = await axios.post('./Api/DeleteBooking.php', formData);

        if (!(typeof response === "object") || !(response?.success)) return alert("Something went wrong please try again later");

        if (response.success) {
          alert("Booking Cancelled Successfully");
          window.location.reload();
          return;
        }

        alert("Something went wrong please try again later");
      })
    })
  </script>
</body>

</html>
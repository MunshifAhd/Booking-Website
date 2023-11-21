<!DOCTYPE html>
<?php include "../../Config/Connection.php";?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Future Booked Details Reports</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="../../index.css" />
  <link rel="stylesheet" href="../DashboardHome.css" />
  <link rel="stylesheet" href="./Css/Report.css" />
  <link rel="stylesheet" text= "text/css" href="./Css/Rep_Booking_print.css" media="print">
</head>

<body>
  <div class="d-flex">

    <section class="flex-grow-1 pt-5">
      <h6 class="fs-5 mont mb-4">Future Bookings details</h6>
      <div class="container">
      <div class="row">
        <div class="col-12">
          <table class="table table-bordered ">
            <thead>
              <tr>

                <th>Branch ID</th>
                <th>Booking id</th>
                <th>Checked in</th>
                <th>Checked out</th>
                <th>Booked Date</th>
                <th>No Of Occupants</th>
                <th>Customer Id</th>
              </tr>
            </thead>
            <tbody>

              <?php
              // $sn = 1;

              $user_query = "SELECT * FROM booking";
              $date_query = "SELECT check_out FROM booking";
             //  $br = $user_query['br_id'];
             // $user_query2 =$mysqli->prepare( "SELECT branch_name from branch where branch_id = ?");
             // $user_query2->bind_param("s", $br);
             // $user_query2->execute();
            if ($user_res = mysqli_query($con,$user_query)
            //  $user_res = mysqli_query($con,$user_query2)
            ) {


              while ($user_data=mysqli_fetch_assoc($user_res) )
              {
                ?>
                <?php if (strtotime($user_data['check_in']) > time() && strtotime($user_data['check_out']) > time()): ?>


                <tr>
                  <td><?php echo $user_data['branch_id']; ?></td>
                  <td><?php echo $user_data['booking_id']; ?></td>
                  <td><?php echo $user_data['check_in']; ?></td>
                  <td><?php echo $user_data['check_out']; ?></td>


                  <td><?php echo $user_data['book_date']; ?></td>
                  <td><?php echo $user_data['no_of_occupants']; ?></td>
                  <td><?php echo $user_data['customer_id']; ?></td>
                </tr>
                  <?php endif; ?>
                <?php
                // $sn++;
            }  }
                 ?>

            </tbody>
          </table>
          <button type="button" name="button" onclick="window.print()" id="print-btn" class="btn btn-success w-100 mt-5 mb-3 center">Print</button>
        </div>
      </div>
      <?php include "./Components/footer.php" ?>
      </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>

<?php
if (session_status() === PHP_SESSION_NONE)
  session_start();
?>

<style>
  .logo-text {
    margin-top: -18px;
    margin-left: 20px;
  }

  .navbar {
    background-color: var(--blue);
  }

  :is(.nav-link, .nav-link:hover) {
    color: white;
  }

  .img-random1 {
    object-fit: contain;
    width: 100%;
    height: auto;
  }

  .img-random1-overlay {
    width: 100%;
    height: 100%;
    background-color: var(--img-overlay);
  }

  .modal-content .btn-red-outlined,
  .modal-content .btn-red-outlined:hover,
  .modal-content .btn-red-outlined:focus {
    display: table;
    border: 1px solid #800000;
    color: #800000;
  }
</style>

<header>
  <nav class="navbar navbar-expand-lg px-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="./home.php">
        <img src="./../../Assets/logo.png" alt="logo" />
        <p class="fs-8 fw-light logo-text color-white">Hotels</p>
      </a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./Booking.php">Booking Rooms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <img src="../../Assets/listDot.png" alt="." class="me-2" />
              Our Branches</a>
          </li>
          <?php
          if (isset($_SESSION["userId"])) {
          ?>
            <li class="nav-item">
              <a href="./MyBookings.php" class="no-underline">
                <button class="nav-link" style="border: none;background-color: transparent;">
                  <img src="../../Assets/listDot.png" alt="." class="me-2" />
                  My Bookings
                </button>
              </a>
            </li>
            <li class="nav-item">
              <a href="./Api/logout.php" class="no-underline">
                <button class="nav-link" style="border: none;background-color: transparent;">
                  <img src="../../Assets/listDot.png" alt="." class="me-2" />
                  Logout
                </button>
              </a>
            </li>
          <?php
          } else { ?>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal" style="border: none;background-color: transparent;">
                <img src="../../Assets/listDot.png" alt="." class="me-2" />
                Login
              </button>
            </li>
          <?php }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content px-5 py-3" method="post" name="loginForm">

        <div class="text-center mb-3 ">
          <img src="./../../Assets/UserIcon.png" alt="" width="80" height="80" />
        </div>
        <label class="mb-3">
          <div class="fw-500 mb-2">Email</div>
          <input type="email" name="email" class="form-control p-2" required />
        </label>
        <label class="mb-5">
          <div class="fw-500 mb-2">Password</div>
          <div class="position-relative">
            <input type="password" name="pass" class="form-control p-2" required />
            <span class="bi bi-eye-fill position-absolute translate-middle-y top-50 end-0 me-2 fs-3" role="button" id="eyeIcon"></span>
          </div>
        </label>
        <button type="submit" class="btn btn-red-outlined mx-auto px-4 mb-4" name="loginSubmit">Login</button>
        <span style="color: black;" class="mx-auto">Not a Member?
          <a id="btnCreateAcc" type="button" style="color:#047EEF;">Create an
            account</a></span>
      </form>
    </div>
  </div>
  <?php
  if (isset($_POST['loginSubmit'])) {
    include './../../Config/Connection.php';

    define('SUCCESS_MESSAGE', '<script>alert("Login successful")</script>');
    define('FAILURE_MESSAGE', '<script>alert("Login failed")</script>');

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if (!empty($email) && !empty($pass)) {
      $query = "SELECT customer_id FROM customer where customer_email='$email' and BINARY customer_password='$pass'";
      $result = mysqli_query($con, $query);

      if (mysqli_num_rows($result) > 0) {
        $_SESSION["userId"] = mysqli_fetch_assoc($result)["customer_id"];
        echo SUCCESS_MESSAGE;
        echo "<script>window.location.href=window.location.href</script>";
        die();
      }
      echo FAILURE_MESSAGE;
    }
    unset($_POST['loginSubmit']);
  }

  ?>

  <!-- signup modal type choose -->

  <div id="signupModalChooseType" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" tabindex="-1">

      <div class="modal-content" style="border-radius: 30px">
        <div class="modal-body d-flex justify-center gap-4 mx-auto" style="padding-top: 100px;padding-bottom: 100px;">

          <div role="button" aria-label="button" id="btnSignupTravelCompany">
            <img class="d-table mx-auto p-4" style="background-color:#6CA6B6; border-radius: 5px; width: 120px; height: auto;" src="./../../Assets/Company.png" alt="" />
            <span class="fs-7">Travel Company</span>
          </div>

          <div role="button" aria-label="button" id="btnSignupSingleCus">
            <img class="d-table mx-auto p-4" style="background-color:#6CA6B6; border-radius: 5px; width: 120px; height: auto;" src="./../../Assets/CheckedUserMale.png" alt="" />
            <span class="fs-7">Single Customer</span>
          </div>

        </div>

      </div>
    </div>
  </div>




  <!-- signup modal single customer -->

  <div class="modal fade" id="signupModalSingleCus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form class="modal-body p-4" method="POST">
          <span style="color:#2A2E43;" class="my-3 d-block">Please fill up the
            below
            information</span>
          <h6 class="modal-title mb-3">
            Owner details
          </h6>

          <div class="mb-4">
            <input required type="text" class="form-control" placeholder="Name" name="name" />
          </div>
          <div class="mb-4">
            <input required type="text" class="form-control" placeholder="Email" name="email" />
          </div>
          <div class="mb-4">
            <input required type="text" class="form-control" name="mobileNo" placeholder="Mobile number" />
          </div>
          <div class="mb-4">
            <input required type="text" class="form-control" name="addr" placeholder="Address" />
          </div>
          <div class="mb-4">
            <input required type="text" class="form-control" name="nic" placeholder="NIC number" />
          </div>
          <div class="mb-4">
            <input required type="password" class="form-control" name="pass" placeholder="Password" />
          </div>

          <button style="background-color: #E0E0E0;color: black; " name="submitSignupUserForm" class="btn mx-auto w-100" type="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <?php

  if (isset($_POST["submitSignupUserForm"])) {
    include dirname(__DIR__) . '/Config/Connection.php';
    include dirname(__DIR__) . "/Services/CustomerType.php";
    include dirname(__DIR__) . "/Services/GenerateCustomerId.php";

    $name = !empty($_POST["name"]) ? $_POST["name"] : null;
    $email = !empty($_POST["email"]) ? $_POST["email"] : null;
    $mobileNo = !empty($_POST["mobileNo"]) ? $_POST["mobileNo"] : null;
    $addr = !empty($_POST["addr"]) ? $_POST["addr"] : null;
    $nic = !empty($_POST["nic"]) ? $_POST["nic"] : null;
    $pass = !empty($_POST["pass"]) ? $_POST["pass"] : null;
    $type = customerType::$single->value;
    $customerId = generateCustomerId($con);

    $query = "
        INSERT INTO customer
        VALUES(
          '$customerId',
          '$name',
          '$email',
          '$nic',
          '$addr',
          '$mobileNo',
          '$type',
          '$pass'
        )";

    if (mysqli_query($con, $query))
      echo "<script>alert('Successfully Signed Up');</script>";

    unset($_POST["submitSignupUserForm"]);
  }

  ?>

  <!-- signupModal travel company -->
  <div class="modal fade" id="signupModalTravelComp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form class="modal-body p-4" method="post">
          <h6 class="modal-title mb-1 fs-5">
            Begin your partnership with Wings
          </h6>
          <span style="color:#2A2E43;" class="mb-3 d-block">Please fill up the
            below
            information</span>
          <div class="mb-4">
            <input required type="text" class="form-control" placeholder="Company Name" name="name" />
          </div>
          <div class="mb-4">
            <input required type="text" class="form-control" name="addr" placeholder="Company Address" />
          </div>

          <h6 class="modal-title mb-3">
            Owner details
          </h6>

          <div class="mb-4">
            <input required type="text" class="form-control" placeholder="Name" name="name" />
          </div>
          <div class="mb-4">
            <input required type="text" class="form-control" placeholder="Email" name="email" />
          </div>
          <div class="mb-4">
            <input required type="text" class="form-control" name="mobileNo" placeholder="Mobile number" />
          </div>
          <div class="mb-4">
            <input required type="password" class="form-control" name="pass" placeholder="Password" />
          </div>

          <button style="background-color: #E0E0E0;color: black; " name="submitSignupCompForm" class="btn mx-auto w-100">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <?php

  if (isset($_POST["submitSignupCompForm"])) {
    include dirname(__DIR__) . '/Config/Connection.php';
    include dirname(__DIR__) . "/Services/CustomerType.php";
    include dirname(__DIR__) . "/Services/GenerateCustomerId.php";

    $name = !empty($_POST["name"]) ? $_POST["name"] : null;
    $email = !empty($_POST["email"]) ? $_POST["email"] : null;
    $mobileNo = !empty($_POST["mobileNo"]) ? $_POST["mobileNo"] : null;
    $addr = !empty($_POST["addr"]) ? $_POST["addr"] : null;
    $nic = !empty($_POST["nic"]) ? $_POST["nic"] : null;
    $pass = !empty($_POST["pass"]) ? $_POST["pass"] : null;
    $type = customerType::$travelCompany->value;
    $customerId = generateCustomerId($con);

    $query = "
      INSERT INTO customer
      VALUES(
        '$customerId',
        '$name',
        '$email',
        '$nic',
        '$addr',
        '$mobileNo',
        '$type',
        '$pass'
      )";

    if (mysqli_query($con, $query))
      echo "<script>alert('Successfully Signed Up');</script>";

    unset($_POST["submitSignupCompForm"]);
  }

  ?>

</header>

<script>
  document.getElementById('btnCreateAcc').addEventListener('click', () => {
    $("#loginModal").modal("hide");
    $("#signupModalChooseType").modal("show");
  })

  document.getElementById("btnSignupTravelCompany").addEventListener('click',
    () => {
      $("#signupModalChooseType").modal("hide");
      $("#signupModalTravelComp").modal("show");
    })
  document.getElementById("btnSignupSingleCus").addEventListener('click', () => {
    $("#signupModalChooseType").modal("hide");
    $("#signupModalSingleCus").modal("show");
  })

  document.loginForm.querySelector('#eyeIcon').addEventListener('click',
    function() {
      let passFieldCurrentType = document.loginForm.pass.getAttribute('type');

      if (passFieldCurrentType === "password") {
        this.classList.replace("bi-eye-fill", "bi-eye-slash-fill")
        document.loginForm.pass.setAttribute('type', "text");
        return;
      }

      this.classList.replace("bi-eye-slash-fill", "bi-eye-fill")
      document.loginForm.pass.setAttribute('type', "password");
    })
</script>

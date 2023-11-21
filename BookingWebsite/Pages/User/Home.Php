<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

unset($_SESSION["branch"]);
unset($_SESSION["chkIn"]);
unset($_SESSION["chkOut"]);
unset($_SESSION["adults"]);
unset($_SESSION["roomType"]);
unset($_SESSION["room"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link href="../../index.css" rel="stylesheet" />
  <link href="./Css/Home.css" rel="stylesheet" />
</head>

<body>
  <?php include "../../Components/Header.php"; ?>

  <div class="img-random1-container position-relative">
    <img src="../../Assets/random1.png" alt="" class="img-random1" />
    <div class="img-random1-overlay position-absolute top-0 d-flex align-items-center justify-content-center flex-column">
      <img src="../../Assets/logo2.png" alt="logo" />
      <p class="fs-2 fw-semibold color-white">Book your perfect trip</p>
      <p class="fs-6 text-center fw-light color-white">
        Come rain or shine wherever you are<br />
        in Sri Lanka, hotel deals are always available on our island for all
        seasons. Regularly <br />refreshed,
      </p>
    </div>
  </div>

  <?php include "../../Components/Filters.php"; ?>

  <div class="our-branch mx-auto">
    <p class="fs-2 ob-title fw-semibold mb-0 text-center">Our Branch</p>
    <p class="fs-6 ob-desc fw-light text-center mb-5">
      Still deciding where to go? Here are some of our favorite places
    </p>
    <div class="row container g-4 color-white">
      <div class="col-4">
        <div class="position-relative">
          <img src="../../Assets/Random/random2.png" alt="" class="our-branch-img" />
          <div class="our-branch-img-overlay"></div>
          <p class="position-absolute ob-img-text fw-semibold fs-4">
            Nuwara eliya
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="position-relative">
          <img src="../../Assets/Random/random1.png" alt="" class="our-branch-img" />
          <div class="our-branch-img-overlay"></div>
          <p class="position-absolute ob-img-text fw-semibold fs-4">Yala</p>
        </div>
      </div>
      <div class="col-4">
        <div class="position-relative">
          <img src="../../Assets/Random/random5.png" alt="" class="our-branch-img" />
          <div class="our-branch-img-overlay"></div>
          <p class="position-absolute ob-img-text fw-semibold fs-4">Kandy</p>
        </div>
      </div>
      <div class="col-4 ms-auto">
        <div class="position-relative">
          <img src="../../Assets/Random/random3.png" alt="" class="our-branch-img" />
          <div class="our-branch-img-overlay"></div>
          <p class="position-absolute ob-img-text fw-semibold fs-4">Jaffna</p>
        </div>
      </div>
      <div class="col-4 me-auto">
        <div class="position-relative">
          <img src="../../Assets/Random/random4.png" alt="" class="our-branch-img" />
          <div class="our-branch-img-overlay"></div>
          <p class="position-absolute ob-img-text fw-semibold fs-4">Galle</p>
        </div>
      </div>
    </div>
  </div>

  <div class="our-home-container position-relative">
    <img src="../../Assets/Random/random6.png" alt="bg" class="our-home-bg-img" />
    <div class="our-home-bg-overlay position-absolute top-0 left-0"></div>

    <div class="our-home-text-container position-absolute top-50 start-50 text-center color-white">
      <h6 class="fs-3 fw-semibold mb-4">
        Our Homes Of Sri Lankan Hospitality
      </h6>
      <p class="fw-normal">
        Spread across the length and breadth of our tropical island, our homes
        of Sri Lankan hospitality invite you to indulge in our signature brand
        of luxury, brought to life with the strength of our well-rooted family
        values. No matter where you may find yourself in Sri Lanka, our doors
        will always be open.
      </p>
    </div>
  </div>

  <?php
  include "../../Components/MYCFooter.php";
  include "../../Components/Footer.php";
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
  </script>
</body>

</html>
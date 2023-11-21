<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
  footer {
    background-color: var(--blue);
  }

  footer .logo {
    width: 150px;
    height: auto;
  }

  footer>div> :nth-child(2) {
    flex-grow: 1;
  }
  </style>
</head>

<body>

  <footer>
    <div class="px-5 d-flex py-4 gap-4 align-items-end color-white">
      <img src="../../Assets/logo2.png" alt="logo" class="logo" />
      <div class="text-center">
        <img src="../../Assets/paymment.png" alt="pay" />
        <hr class="my-3" />
        <p class="fw-light fs-7 m-0">© 2021 Wingshoteks.com</p>
      </div>
      <div class="text-end">
        <p class="fs-6 fw-light mb-2">Our Branches</p>
        <p class="fs-6 fw-light mb-2">Our services</p>
        <p class="fs-6 fw-light mb-2">Contact us</p>
        <img src="../../Assets/Social Media Icons/facebook white.png" alt="fb"
          class="me-2" />
        <img src="../../Assets/Social Media Icons/insta white.png"
          alt="instagram" />
      </div>
    </div>
  </footer>

</body>

</html>
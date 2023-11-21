<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
    crossorigin="anonymous" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../../index.css" />
  <link rel="stylesheet" href="./Css/AdminLogin.css" />
</head>

<body>

  <form class="login-form" name="loginForm" method="post" action="#">
    <div class="text-center mb-3">
      <img src="../../Assets/UserIcon.png" alt="" width="80" height="80" />
    </div>
    <label class="mb-3">
      <div class="fw-500 mb-2">Administrator Id</div>
      <input type="text" name="adminId" class="form-control p-2" required />
    </label>
    <label class="mb-5">
      <div class="fw-500 mb-2">Password</div>
      <div class="position-relative">
        <input type="password" name="pass" class="form-control p-2" required />
        <span
          class="bi bi-eye-fill position-absolute translate-middle-y top-50 end-0 me-2 fs-3"
          role="button" id="eyeIcon"></span>
      </div>
    </label>
    <button type="submit" class="btn mx-auto px-4" name="submit">Login</button>
  </form>
  <button id="toggleMdl" type="button" class="btn btn-primary " hidden
    data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>
  <?php
  if (isset($_POST["submit"])) {
    include "../../Config/Connection.php";

    $adminId = $_POST["adminId"];
    $pass = $_POST["pass"];

    $query = "SELECT * FROM admin WHERE BINARY admin_id='$adminId' AND BINARY password='$pass'";
    $res = mysqli_query($con, $query);

    if (mysqli_num_rows($res) > 0) {
      echo "<script>window.location.href='./DashboardHome.php'</script>";
      $_SESSION["adminId"] = mysqli_fetch_assoc($res)["admin_id"];
    } else {
      echo "<script>document.querySelector('#toggleMdl').click()</script>";
    }
  }
  ?>
  <div class="modal fade" id="exampleModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            <span class="bi bi-exclamation-circle-fill "></span>
            Error
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body text-danger">
          Failed to login, Id or Password incorrect.
        </div>
      </div>
    </div>
  </div>
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
    crossorigin="anonymous"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
    integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK"
    crossorigin="anonymous"></script>

  <script>
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
</body>

</html>
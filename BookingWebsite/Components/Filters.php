<?php
include(dirname(__DIR__) . "/Config/Connection.php");

if (isset($_POST["filterRoom"])) {
  $_SESSION["branch"] = !empty($_POST["branch"]) ? trim($_POST["branch"]) : null;
  $_SESSION["chkIn"] = !empty($_POST["chkIn"]) ? trim($_POST["chkIn"]) : null;
  $_SESSION["chkOut"] = !empty($_POST["chkOut"]) ? trim($_POST["chkOut"]) : null;
  $_SESSION["adults"] = !empty($_POST["adults"]) ? trim($_POST["adults"]) : null;
  $_SESSION["roomType"] = !empty($_POST["roomType"]) ? trim($_POST["roomType"]) : null;
  $_SESSION["room"] = !empty($_POST["room"]) ? trim($_POST["room"]) : null;

  unset($_POST["filterRoom"]);
  echo "<script>window.location='Booking.php';</script>";
}

?>
<style>
  .filters {
    border: 1px solid var(--grey);
    transform: translateY(-50%);
    width: 80%;
  }

  .filters>*:not(:last-child) {
    color: var(--grey);
    border: 1px solid var(--grey);
    background-color: var(--white);
    margin-right: 10px;
  }

  .filters>input::placeholder {
    color: var(--grey);
  }

  .filters>.btn {
    background-color: var(--green);
    color: white;
  }
</style>
<form class="bg-white filters py-2 px-4 mx-auto d-flex justify-content-between" method="post" name="filterForm">
  <select name="branch" class="form-select form-select-sm">
    <option selected disabled hidden>Branch</option>
    <?php
    $query = "SELECT branch_name FROM branch";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
    ?>

        <option value="<?php echo $row[0] ?>" style="color:black" <?php if (isset($_SESSION["branch"]) &&  $_SESSION["branch"] == $row[0]) echo 'selected'; ?>>
          <?php echo $row[0] ?>
        </option>

    <?php
      }
    }
    ?>
  </select>
  <input name="chkIn" class="form-control form-control-sm" placeholder="Check-in" type="text" onfocus="this.type='date'" onBlur="this.type='text'" value="<?php echo isset($_SESSION["chkIn"]) ? $_SESSION["chkIn"] : "" ?>" />

  <input name="chkOut" class="form-control form-control-sm" placeholder="Check-out" type="text" onfocus="this.type='date'" onBlur="this.type='text'" value="<?php echo isset($_SESSION["chkOut"]) ? $_SESSION["chkOut"] : "" ?>" />

  <input name="adults" class="form-control form-control-sm" placeholder="Adults" type="text" inputmode="numeric" pattern="\d*" title="Only Numbers are allowed" value="<?php echo isset($_SESSION["adults"]) ? $_SESSION["adults"] : "" ?>" />

  <select name="roomType" id="" class="form-select form-select-sm">
    <option disabled selected hidden>Type</option>

    <option <?php if (isset($_SESSION["roomType"]) &&  $_SESSION["roomType"] == "Villa") echo 'selected'; ?> value="Villa" class="text-black">Villa
    </option>

    <option <?php if (isset($_SESSION["roomType"]) &&  $_SESSION["roomType"] == "Room") echo 'selected'; ?> value="Room" class="text-black">Room</option>

  </select>
  <button name="filterRoom" class="btn btn-sm" style="white-space: nowrap" type="submit">
    Find Room
  </button>
</form>

<script>
  if (document.filterForm.chkIn.value)
    document.filterForm.chkOut.setAttribute("required", true)

  document.filterForm.chkIn.addEventListener('change', function() {
    if (this.value)
      document.filterForm.chkOut.setAttribute("required", true)
  })
</script>
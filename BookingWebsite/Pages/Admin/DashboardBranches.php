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
  <title>Branches</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="./../../index.css" />
  <style>
    .table-container {
      border-radius: 21px;
      background-color: var(--white);
      height: 200px;
      overflow-y: auto;
    }

    .branch-form .form-control {
      background-color: var(--white2);
      border: none;
    }

    .branch-form .btn {
      border: none;
    }

    .branch-form :is(.btn:hover, .btn:focus) {
      color: white;
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <?php include "./Components/Sidebar.php" ?>

    <section class="flex-grow-1 px-5 pt-4">
      <div class="d-flex align-items-center mb-5">
        <span class="fs-4 fw-semibold color-blue">Branches</span>
        <input class="form-control ms-auto me-3" style="max-width:250px" placeholder="Branch Name" id="searchBranch" />
      </div>

      <div class="px-4 table-container">
        <table class="table" aria-label="branch table" id="branchTable">
          <thead style="white-space: nowrap;">
            <tr>
              <th scope="col">Branch ID</th>
              <th scope="col">Name</th>
              <th scope="col">Description</th>
              <th scope="col">Phone Number</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "./../../Config/Connection.php";

            $query = "SELECT * FROM branch";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {

            ?>
                <tr data-id="<?php echo $row["branch_id"]; ?>" data-name="<?php echo $row["branch_name"]; ?>" data-description="<?php echo $row["branch_description"]; ?>" data-phoneno="<?php echo $row["branch_phone_number"]; ?>">
                  <td><?php echo $row["branch_id"]; ?></td>
                  <td><?php echo $row["branch_name"]; ?></td>
                  <td><?php echo $row["branch_description"]; ?></td>
                  <td><?php echo $row["branch_phone_number"]; ?></td>
                </tr>
              <?php
              }
            } else {
              ?>
              <tr style="pointer-events: none;">
                <td colspan="4" class="text-center">No Records Found</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>

      <form class="container-fluid ms-0 my-5 branch-form" name="branchForm" method="POST">
        <div class="row g-3">

          <div class="col-3 fw-500 fs-6">
            <label>Branch ID</label>
          </div>
          <div class="col-4">
            <input name="branchId" placeholder="Branch ID" class="form-control" type="text" readonly value="<?php include './../../Services/GenerateBranchId.php';
                                                                                                            echo generateBranchId($con)  ?>" />
          </div>

          <div class="w-100"></div>

          <div class="col-3 fw-500 fs-6">
            <label>Branch Name</label>
          </div>
          <div class="col-4">
            <input required name="name" placeholder="Branch Name" class="form-control" type="text" />
          </div>

          <div class="w-100"></div>

          <div class="col-3 fw-500 fs-6">
            <label>Branch Description</label>
          </div>
          <div class="col-4">
            <textarea required name="desc" placeholder="Branch Description" class="form-control" style="resize:none;" rows="4"></textarea>
          </div>

          <div class="w-100"></div>

          <div class="col-3 fw-500 fs-6">
            <label>Branch Phone Number</label>
          </div>
          <div class="col-4">
            <input required name="phoneNumber" placeholder="Phone Number" class="form-control" type="text" inputmode="tel" />
          </div>

          <div class="w-100"></div>

          <div class="col-5"></div>

          <div class="col-2">
            <button name="btnAdd" class="btn w-100 btn-blue" type="submit">Add</button>
          </div>
          <div class="col-2">
            <button name="btnEdit" class="btn w-100 btn-green" type="submit" disabled>Edit</button>
          </div>
          <div class="col-2">
            <button name="btnDel" class="btn w-100 btn-red" type="submit" disabled>Delete</button>
          </div>
        </div>
      </form>

      <?php
      //add button
      if (isset($_POST['btnAdd'])) {
        $branchId = !empty($_POST["branchId"]) ? trim($_POST["branchId"]) : null;
        $name = !empty($_POST["name"]) ? trim($_POST["name"]) : null;
        $desc = !empty($_POST["desc"]) ? trim($_POST["desc"]) : null;
        $phoneNumber = !empty($_POST["phoneNumber"]) ? trim($_POST["phoneNumber"]) : null;

        $query = "INSERT INTO branch VALUES ('$branchId','$name','$desc','$phoneNumber')";

        if (mysqli_query($con, $query))
          echo "<script>
          alert('Branch Added Successfully');
          window.location.href = window.location.href
           </script>";
        else
          echo "<script>alert('Failed to add Branch')</script>";
      }

      if (isset($_POST['btnEdit'])) {
        $branchId = !empty($_POST["branchId"]) ? trim($_POST["branchId"]) : null;
        $name = !empty($_POST["name"]) ? trim($_POST["name"]) : null;
        $desc = !empty($_POST["desc"]) ? trim($_POST["desc"]) : null;
        $phoneNumber = !empty($_POST["phoneNumber"]) ? trim($_POST["phoneNumber"]) : null;

        $query = "UPDATE branch SET branch_name='$name', branch_description='$desc', branch_phone_number='$phoneNumber' WHERE branch_id='$branchId'";

        if (mysqli_query($con, $query))
          echo "<script>alert('Branch Updated Successfully')
          window.location.href = window.location.href</script>";
        else
          echo "<script>alert('Failed to Update Branch')</script>";
      }

      if (isset($_POST['btnDel'])) {
        $branchId = !empty($_POST["branchId"]) ? $_POST["branchId"] : null;

        $query = "DELETE FROM branch WHERE branch_id ='$branchId'";

        if (mysqli_query($con, $query))
          echo "<script>alert('Branch Deleted Successfully')
        window.location.href = window.location.href</script>";
        else
          echo "<script>alert('Failed to Deleted Branch')</script>";
      }
      ?>

      <?php include "./Components/footer.php" ?>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    function bindEventsToTableRows() {
      const tableRows = document.querySelector('#branchTable')
        .getElementsByTagName(
          'tbody')[0].getElementsByTagName('tr');

      for (let row of tableRows) {
        row.addEventListener('click', function() {
          const {
            id,
            name,
            description,
            phoneno
          } = this.dataset;
          document.branchForm.branchId.value = id;
          document.branchForm.name.value = name;
          document.branchForm.desc.value = description;
          document.branchForm.phoneNumber.value = phoneno;

          const {
            btnAdd,
            btnEdit,
            btnDel
          } = document.branchForm;

          btnAdd.setAttribute("disabled", true);
          btnDel.removeAttribute("disabled");
          btnEdit.removeAttribute("disabled");

        })
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      bindEventsToTableRows();
    })

    document.querySelector("#searchBranch").addEventListener('input',
      function() {
        const formData = new FormData();
        formData.set('textToSearch', this.value)

        axios.post('./Api/FilteredBranches.php', formData).then(({
          data
        }) => {
          if (data.length) {
            let branchTableRows = "";
            data.forEach((row) => {
              branchTableRows += `
            <tr data-id="${row.id}" data-name="${row.name}"
              data-description="${row.desc}" data-phoneno="${row.phoneNo}">
              <td>${row.id}</td>
              <td>${row.name}</td>
              <td>${row.desc}</td>
              <td>${row.phoneNo}</td>
            </tr>`;
            })
            document.querySelector('#branchTable tbody').innerHTML =
              branchTableRows;
            return bindEventsToTableRows();
          }
          document.querySelector('#branchTable tbody').innerHTML =
            "<tr style='pointer-events:none;'><td colspan='4' class='text-center'>No Results Found</tr>"
        })
      })
  </script>
</body>

</html>

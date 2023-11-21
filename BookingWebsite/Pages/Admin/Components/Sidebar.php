<style>
.sidebar>* {
  white-space: nowrap;
  font-family: "Montserrat", sans-serif;
}

.sidebar {
  background-color: var(--blue);
}

.sidebar>*:hover {
  color: white;
}

.sidebar img {
  margin-left: -20px;
}
</style>
<section class="sidebar min-vh-100 p-5">
  <img class="mb-5" src="../../Assets/logo2.png" alt="" width="150" />
  <a href="<?php echo  "DashboardHome.php"; ?>"
    class="fw-500 fs-7 mb-3 color-white d-block no-underline">Home</a>
  <a href="DashboardNewBooking.php"
    class="fw-500 fs-7 mb-3 color-white d-block no-underline">New
    Bookings</a>
  <a href="DashboardManageBooking.php"
    class="fw-500 fs-7 mb-3 color-white d-block no-underline">Manage
    Booking</a>
  <a href="DashboardInvoice.php"
    class="fw-500 fs-7 mb-3 color-white d-block no-underline">Invoice</a>
  <a href="report.php"
    class="fw-500 fs-7 mb-3 color-white d-block no-underline">Reports</a>
  <a href="DashboardRoomsAndVillas.php"
    class="fw-500 fs-7 mb-3 color-white d-block no-underline">Add Rooms
    and
    Villas</a>
  <a href="DashboardBranches.php"
    class="fw-500 fs-7 mb-3 color-white d-block no-underline">Branches</a>
  <a href="logout.php"
    class="fw-500 fs-7 mb-3 color-white d-block no-underline">Logout</a>
</section>

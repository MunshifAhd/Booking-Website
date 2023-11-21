const tableRows = document.querySelectorAll("#table tbody tr");

for (const row of tableRows) {
  row.addEventListener("click", function () {
    const formData = new FormData();
    formData.set("bookingId", this.dataset.id);

    try {
      axios
        .post("./Api/getBookingDetails.php", formData)
        .then(function ({ data: response }) {
          if (response.length) {
            response = response[0];
            const { price, room_id, villa_id } = response;

            document.BookingForm.branch.value = response.branch_name;
            document.BookingForm.chkIn.value = response.check_in;
            document.BookingForm.chkOut.value = response.check_out;
            document.BookingForm.adults.value = response.no_of_occupants;
            if (room_id) {
              document.BookingForm.roomType.value = "Room";
              document.BookingForm.room.value = room_id;
            }
            if (villa_id) {
              document.BookingForm.roomType.value = "Villa";
              document.BookingForm.room.value = villa_id;
            }

            document.BookingForm.guestName.value = response.customer_name;
            document.BookingForm.addr.value = response.customer_address;
            document.BookingForm.nic.value = response.customer_nic;
            document.BookingForm.email.value = response.customer_email;
            document.BookingForm.phNo.value = response.customer_phone_number;
            document.BookingForm.guestType.value = response.customer_type;

            const { cardNo, cvcCode, cardExpiry } = document.BookingForm;
            cardNo.value = response.creditcard_number;
            cvcCode.value = response.cvn;
            cardExpiry.value = response.expiry;

            //hidden id's
            document.BookingForm.customerId.value = response.customer_id;
            document.BookingForm.bookingId.value = response.booking_id;
            document.BookingForm.paymentId.value = response.payment_id;

            const curFormatter = Intl.NumberFormat("default", {
              style: "currency",
              currency: "LKR",
            });

            document.getElementById("totalAmount").textContent =
              curFormatter.format(price);

            document.getElementById("form").classList.remove("d-none");
            document.getElementById("table").classList.add("d-none");
          }
        });
    } catch (error) {
      alert("Something went wrong please try again later");
    }
  });
}

document.getElementById("closeBtn").addEventListener("click", function () {
  document.querySelector("#form form").reset();
  document.getElementById("form").classList.add("d-none");
  document.getElementById("table").classList.remove("d-none");
});

document.BookingForm.delete.addEventListener("click", event => {
  if (!confirm("Are you sure you want to cancel this booking?"))
    event.preventDefault();
});

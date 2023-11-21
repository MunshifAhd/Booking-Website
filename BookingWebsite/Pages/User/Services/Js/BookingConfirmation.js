const { chkIn, chkOut } = document.bookingConfirmationForm;

chkIn.addEventListener("change", function () {
  if (
    this.value &&
    chkOut.value &&
    new Date(chkOut.value).getTime() <= new Date(this.value).getTime()
  ) {
    this.value = "";
    return;
  }

  const chkInP = document.querySelector(".book-conf-container #chkIn");
  chkInP.innerText = new Date(this.value).toLocaleDateString("default", {
    dateStyle: "long",
  });
});

chkOut.addEventListener("change", function () {
  if (
    this.value &&
    new Date(this.value).getTime() <= new Date(chkIn.value).getTime()
  ) {
    this.value = "";
    return;
  }

  const chkOutP = document.querySelector(".book-conf-container #chkOut");
  chkOutP.innerText = new Date(this.value).toLocaleDateString("default", {
    dateStyle: "long",
  });
});

document.addEventListener("DOMContentLoaded", function () {
  let today = new Date();
  let dd = today.getDate();
  let mm = today.getMonth() + 1;
  let yyyy = today.getFullYear();

  if (dd < 10) dd = "0" + dd;

  if (mm < 10) mm = "0" + mm;

  today = yyyy + "-" + mm + "-" + dd;
  chkIn.setAttribute("min", today);
});

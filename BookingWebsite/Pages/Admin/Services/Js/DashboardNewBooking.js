const { branch, chkIn, chkOut, adults, roomType, room } =
  document.newBookingForm;

branch.addEventListener("input", generateFilteredRooms);
chkIn.addEventListener("input", generateFilteredRooms);
chkOut.addEventListener("input", generateFilteredRooms);
adults.addEventListener("input", generateFilteredRooms);
roomType.addEventListener("input", generateFilteredRooms);

roomType.addEventListener("input", function () {
  room.options[0].textContent = this.value;
});

async function generateFilteredRooms() {
  const formData = new FormData();
  formData.set("branchId", branch.value);
  formData.set("chkIn", chkIn.value);
  formData.set("chkOut", chkOut.value);
  formData.set("adults", adults.value);
  formData.set("type", roomType.value);

  try {
    let filteredOptions;
    const roomSelect = document.newBookingForm.room;

    const { data: response } = await axios.post(
      "./Api/loadFilteredRooms.php",
      formData
    );

    if (!response.length) {
      const roomSelectOptions =
        roomSelect.options[0].outerHTML +
        `<option class="text-start" style="color:black;" value="" disabled>No Rooms/Villas Available</option>`;
      roomSelect.innerHTML = roomSelectOptions;
      return;
    }

    response.forEach(
      roomId =>
        (filteredOptions += `<option class="text-start" style="color:black;" value='${roomId}'>${roomId}</option>`)
    );
    roomSelect.innerHTML = roomSelect.options[0].outerHTML + filteredOptions;
  } catch (error) {}
}

//setting price on id changes
room.addEventListener("change", function () {
  const currencyFormatter = Intl.NumberFormat("default", {
    style: "currency",
    currency: "usd",
  });

  const formData = new FormData();
  formData.set("id", this.value);

  if (room.value)
    return axios
      .post("./Api/price.php", formData)
      .then(({ data: responseData }) => {
        document.getElementById("totalAmountTemp").textContent = `${
          currencyFormatter.format(Number(responseData[0])).split("$")[1]
        }`;
        document.getElementById("totalAmount").value = Number(responseData[0]);
      });

  document.getElementById("totalAmountTemp").textContent = "0.00";
  document.getElementById("totalAmount").value = "0";
});

const mutationObserverRoomSelectOptions = new MutationObserver(() => {
  document.getElementById("totalAmountTemp").textContent = "0.00";
  document.getElementById("totalAmount").value = "0";
});

mutationObserverRoomSelectOptions.observe(room, {
  subtree: true,
  childList: true,
});

chkIn.addEventListener("input", function () {
  if (this.value) {
    chkOut.disabled = false;
    if (
      chkOut.value &&
      new Date(chkOut.value).getTime() <= new Date(this.value).getTime()
    )
      this.value = "";
  }
});

chkOut.addEventListener("input", function () {
  if (
    this.value &&
    new Date(this.value).getTime() <= new Date(chkIn.value).getTime()
  )
    this.value = "";
});

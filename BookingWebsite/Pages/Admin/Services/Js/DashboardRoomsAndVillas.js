//switching between rooms and villas
document.querySelector("#tabBtnRoom").addEventListener("click", () => {
  document.getElementById("villa").style.display = "none";
  document.getElementById("room").style.display = "block";
  document.getElementById("searchBranchRoom").style.display = "block";
  document.getElementById("searchBranchVilla").style.display = "none";
});
document.querySelector("#tabBtnVilla").addEventListener("click", () => {
  document.getElementById("room").style.display = "none";
  document.getElementById("villa").style.display = "block";
  document.getElementById("searchBranchVilla").style.display = "block";
  document.getElementById("searchBranchRoom").style.display = "none";
});

//adding room table row click events
function bindEventsToTableRows() {
  const tableRows = document.querySelectorAll("#roomTable tbody tr");
  for (let row of tableRows) {
    row.addEventListener("click", function () {
      const { id, title, description, beds, occupancy, price, img, branchid } =
        this.dataset;

      document.roomForm.btnAdd.setAttribute("disabled", true);
      document.roomForm.branch.setAttribute("disabled", true);
      document.roomForm.btnDel.removeAttribute("disabled");
      document.roomForm.btnEdit.removeAttribute("disabled");

      document.roomForm.roomId.value = id;
      document.roomForm.title.value = title;
      document.roomForm.desc.value = description;
      document.roomForm.noOfBeds.value = Number(beds);
      document.roomForm.occupancy.value = Number(occupancy);
      document.roomForm.price.value = price;
      document.roomForm.branch.value = branchid;

      document.getElementById(
        "imgRoomContainer"
      ).innerHTML = `<img src="./../../${img}" style="border-radius: 5px;width: 250px;height: auto; object-fit: cover;"/>`;
    });
  }
}
//check room image available
document.roomForm.addEventListener("submit", function (event) {
  if (this.img.files.length === 0) {
    event.preventDefault();
    alert("Please select an image");
  }
});

//adding villa table row click events
function bindEventsToTableRowsVilla() {
  const tableRows = document.querySelectorAll("#villaTable tbody tr");
  for (let row of tableRows) {
    row.addEventListener("click", function () {
      const {
        id,
        title,
        description,
        beds,
        occupancy,
        rooms,
        price,
        img,
        branchid,
      } = this.dataset;

      document.villaForm.btnAdd.setAttribute("disabled", true);
      document.villaForm.branch.setAttribute("disabled", true);
      document.villaForm.btnDel.removeAttribute("disabled");
      document.villaForm.btnEdit.removeAttribute("disabled");

      document.villaForm.villaId.value = id;
      document.villaForm.title.value = title;
      document.villaForm.desc.value = description;
      document.villaForm.noOfBeds.value = Number(beds);
      document.villaForm.noOfRooms.value = Number(rooms);
      document.villaForm.occupancy.value = Number(occupancy);
      document.villaForm.price.value = price;
      document.villaForm.branch.value = branchid;

      document.getElementById(
        "imgVillaContainer"
      ).innerHTML = `<img src="./../../${img}" style="border-radius: 5px;width: 250px;height: auto; object-fit: cover;"/>`;
    });
  }
}

//CHECKIN IMAGE
document.villaForm.addEventListener("submit", function (event) {
  if (this.img.files.length === 0) {
    event.preventDefault();
    alert("Please select an image");
  }
});

//room id auto generate
async function loadRoomIdToTextFiled() {
  const selectedBranch = document.roomForm.branch.value;
  const selectedBranchName =
    document.roomForm.branch.selectedOptions[0].innerText.trim();

  const formData = new FormData();
  formData.set("branchId", selectedBranch);
  formData.set("branchName", selectedBranchName);

  try {
    const { data: response } = await axios.post(
      "./Api/generateRoomId.php",
      formData
    );

    document.roomForm.roomId.value = response.toString();
  } catch (error) {}
}
document.roomForm.branch.addEventListener("change", loadRoomIdToTextFiled);

//run after load
document.addEventListener("DOMContentLoaded", () => {
  //room
  bindEventsToTableRows();
  loadRoomIdToTextFiled();
  document.roomForm.btnDel.setAttribute("disabled", true);
  document.roomForm.btnEdit.setAttribute("disabled", true);

  //villa
  bindEventsToTableRowsVilla();
  document.villaForm.btnDel.setAttribute("disabled", true);
  document.villaForm.btnEdit.setAttribute("disabled", true);
});

//search bars
const searchRoom = document.getElementById("searchBranchRoom");
const searchVilla = document.getElementById("searchBranchVilla");

searchRoom.addEventListener("input", async function () {
  try {
    let value = this.value.replaceAll("\\", "\\\\");

    const { data: response } = await axios.get(
      `./Api/getFilteredRoomDetails.php?searchText=${value}`
    );

    const roomTableRows = document.querySelector("#roomTable tbody");

    if (response.length === 0) {
      roomTableRows.innerHTML = `<tr style="pointer-events: none;"><td colspan="7" class="text-center">No Records Found</td></tr>`;
      return;
    }

    const tableHTMLArr = response.map(
      row => `
      <tr 
        data-id="${row.room_id}" 
        data-title="${row.title}" 
        data-description="${row.description}"
        data-beds="${row.no_of_beds}"
        data-occupancy="${row.occupancy}" 
        data-price="${row.price}" 
        data-img="${row.img}" 
        data-branchid="${row.branch_id}">
        <td class="ws-nowrap">${row.room_id}</td>
        <td>${row.title}</td>
        <td>${row.description}</td>
        <td>${row.no_of_beds}</td>
        <td>${row.occupancy}</td>
        <td>${row.price}</td>
        <td>${row.branch_name}</td>
      </tr>`
    );

    roomTableRows.innerHTML = tableHTMLArr.join("");
    bindEventsToTableRows();
  } catch (error) {
    alert("Something went wrong please try again later.");
  }
});

searchVilla.addEventListener("input", async function () {
  try {
    let value = this.value.replaceAll("\\", "\\\\");

    const { data: response } = await axios.get(
      `./Api/getFilteredVillaDetails.php?searchText=${value}`
    );

    const villaTableRows = document.querySelector("#villaTable tbody");

    if (response.length === 0) {
      villaTableRows.innerHTML = `<tr style="pointer-events: none;"><td colspan="8" class="text-center">No Records Found</td></tr>`;
      return;
    }

    const tableHTMLArr = response.map(
      row => `
        <tr data-id="${row.villa_id}"
            data-title="${row.title}"
            data-description="${row.description}"
            data-beds="${row.no_of_beds}"
            data-rooms="${row.no_of_rooms}"
            data-occupancy="${row.occupancy}"
            data-price="${row.price}"
            data-img="${row.img}"
            data-branchid="${row.branch_id}">
          <td class="ws-nowrap">${row.villa_id}</td>
          <td>${row.title}</td>
          <td>${row.description}</td>
          <td>${row.no_of_beds}</td>
          <td>${row.no_of_rooms}</td>
          <td>${row.occupancy}</td>
          <td>${row.price}</td>
          <td>${row.branch_name}</td>
        </tr>`
    );

    villaTableRows.innerHTML = tableHTMLArr.join("");
    bindEventsToTableRowsVilla();
  } catch (error) {
    alert("Something went wrong please try again later.");
  }
});

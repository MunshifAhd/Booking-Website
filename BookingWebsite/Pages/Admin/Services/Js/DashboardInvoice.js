import formatToCurrency from "./FormatToCurrency.js";

const grandTotal = document.getElementById("grandTotal");
const subTotal = document.getElementById("subTotal");
const additionalCharges = document.getElementById("additionalCharges");

const bindEventListenerTblRowClk = () => {
  document
    .querySelectorAll("#bookingTable tbody tr")
    .forEach(tr => tr.addEventListener("click", handleClickTblRow));
};

document.addEventListener("DOMContentLoaded", () => {
  bindEventListenerTblRowClk();
});

async function handleClickTblRow() {
  try {
    let {
      data: [response],
    } = await axios.get(
      `./Api/getBookingDetailsInvoice.php?bookingId=${this.dataset.booking_id}`
    );

    const chkInDate = document.getElementById("chkInDate");
    const chkOutDate = document.getElementById("chkOutDate");
    const title = document.getElementById("title");
    const desc = document.getElementById("desc");
    const name = document.getElementById("name");
    const addr = document.getElementById("addr");
    const noc = document.getElementById("noc");
    const pNo = document.getElementById("pNo");
    const cardNo = document.getElementById("cardNo");

    document.invoiceForm.paymentId.value = response.payment_id;
    document.invoiceForm.bookingId.value = response.booking_id;

    chkInDate.textContent = convertToMediumDate(response.check_in);
    chkOutDate.textContent = convertToMediumDate(response.check_out);
    title.textContent = response.title;
    desc.textContent = response.description;
    name.textContent = response.customer_name;
    addr.textContent = response.customer_address;
    noc.textContent = response.customer_nic;
    pNo.textContent = response.customer_phone_number;
    subTotal.textContent = formatToCurrency(response.payment);

    if (response?.creditcard_number) {
      document
        .getElementById("paymentSection")
        .classList.replace("d-none", "d-block");
      cardNo.textContent =
        "*".repeat(response?.creditcard_number.length - 4) +
        response?.creditcard_number.substr(-4);
    }

    if (!response?.creditcard_number) {
      document
        .getElementById("paymentSection")
        .classList.replace("d-block", "d-none");
    }

    document
      .getElementById("bookingDetails")
      .classList.replace("d-none", "d-flex");
  } catch (error) {
    alert("Something went wrong please try again later.");
  }
}

const convertToMediumDate = date =>
  new Date(date).toLocaleDateString("default", {
    year: "2-digit",
    day: "2-digit",
    month: "short",
    weekday: "short",
  });

//updating AdditionalCharges

const updateAdditionalCharges = () => {
  const restaurantBillsVal = isNaN(Number(restaurantBills.value))
    ? null
    : Number(restaurantBills.value);
  const swimmingPoolVal = isNaN(Number(swimmingPool.value))
    ? null
    : Number(swimmingPool.value);
  const mealsVal = isNaN(Number(meals.value)) ? null : Number(meals.value);
  const extraKeysVal = isNaN(Number(extraKeys.value))
    ? null
    : Number(extraKeys.value);
  const telephoneServiceVal = isNaN(Number(telephoneService.value))
    ? null
    : Number(telephoneService.value);
  const clubServiceVal = isNaN(Number(clubService.value))
    ? null
    : Number(clubService.value);

  if (
    typeof restaurantBillsVal === "number" &&
    typeof swimmingPoolVal === "number" &&
    typeof mealsVal === "number" &&
    typeof extraKeysVal === "number" &&
    typeof telephoneServiceVal === "number" &&
    typeof clubServiceVal === "number"
  ) {
    const additionalChargesVal =
      restaurantBillsVal +
      swimmingPoolVal +
      mealsVal +
      extraKeysVal +
      telephoneServiceVal +
      clubServiceVal;
    document.getElementById("additionalCharges").textContent =
      formatToCurrency(additionalChargesVal);
    document.invoiceForm.additionalCharges.value = additionalChargesVal;
  }
};

const {
  restaurantBills,
  swimmingPool,
  meals,
  extraKeys,
  telephoneService,
  clubService,
} = document.invoiceForm;

restaurantBills.addEventListener("blur", updateAdditionalCharges);
swimmingPool.addEventListener("blur", updateAdditionalCharges);
meals.addEventListener("blur", updateAdditionalCharges);
extraKeys.addEventListener("blur", updateAdditionalCharges);
telephoneService.addEventListener("blur", updateAdditionalCharges);
clubService.addEventListener("blur", updateAdditionalCharges);

const mutationObserver = new MutationObserver(() => {
  const grandTotalVal =
    Number(subTotal.textContent.toString().replaceAll(",", "")) +
    Number(additionalCharges.textContent.toString().replaceAll(",", ""));
  grandTotal.textContent = formatToCurrency(grandTotalVal);
});

mutationObserver.observe(subTotal, { childList: true });
mutationObserver.observe(additionalCharges, { childList: true });

//search
document.getElementById("searchBranch").addEventListener("input", function () {
  axios
    .get(`./Api/getFilteredBookingDetails.php?brName=${this.value}`)
    .then(({ data: response }) => {
      if (response.length) {
        let branchTableRows = "";
        response.forEach(row => {
          branchTableRows += `
          <tr  class="ws-nowrap" data-booking_id=${row.booking_id}>
          <td>${row.booking_id}</td>
          <td>${row.check_in}</td>
          <td>${row.check_out}</td>
          <td>${row.book_date}</td>
          <td>${row.no_of_occupants}</td>
          <td>${row.booking_status}</td>
          <td>${row.villa_id ?? ""}</td>
          <td>${row.room_id ?? ""}</td>
          <td>${row.customer_name}</td>
        </tr>`;
        });
        document.querySelector("#bookingTable tbody").innerHTML =
          branchTableRows;
        bindEventListenerTblRowClk();
        return;
      }
      document.querySelector("#bookingTable tbody").innerHTML =
        "<tr style='pointer-events:none;'><td colspan='9' class='text-center'>No Records Found</tr>";
    });
});

document.getElementById("btnPrint").addEventListener("click", () => {
  const pdf = new jsPDF("p", "pt", "a4");
  pdf.text("Transfer Details", 10, 10);
  autoTable(pdf, {
    head: [["Name", "Email", "Country"]],
    body: [
      ["David", "david@example.com", "Sweden"],
      ["Castille", "castille@example.com", "Spain"],
      // ...
    ],
  });
  pdf.save("TransferDetails.pdf");
});

document
  .getElementById("filterByDate")
  .addEventListener("change", async function () {
    try {
      let { data: response } = await axios.get(
        `./Api/getTransferDetails.php?date=${this.value}`
      );

      const paymentTable = document.querySelector("#paymentTable tbody");

      if (response.length == 0) {
        paymentTable.innerHTML = `
        <tr>
          <td colspan="8" class="text-center">No Records Found</td>
        </tr>`;
        return;
      }

      const paymentTableHTML = response.map(
        row => `
        <tr>
          <td>${row.payment_id}</td>
          <td>${row.type}</td>
          <td>${row.date}</td>
          <td>${row.addition}</td>
          <td>${row.payment}</td>
          <td>${row.creditcard_number}</td>
          <td>${row.expiry}</td>
          <td>${row.cvn}</td>
        </tr>`
      );

      paymentTable.innerHTML = paymentTableHTML.join("");
    } catch (error) {
      alert("Something went wrong please try again.");
    }
  });

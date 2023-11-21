const currencyFormatter = Intl.NumberFormat("default", {
  style: "currency",
  currency: "usd",
});

const formatToCurrency = number =>
  currencyFormatter.format(number).split("$")[1];

export default formatToCurrency;

url = window.location.href;
isOrderManagerPage = url.includes("orders-manager");

if (isOrderManagerPage) {
  window.setTimeout(function () {
    window.location.reload();
  }, 60000);
}

function editOrder(path) {
  window.open(path, "_blank");
}

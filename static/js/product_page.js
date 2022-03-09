const MAX_QUANTITY = document.getElementById("max-quantity").value;
const QTY = document.getElementById("qty");
const SYNC_QTY = document.getElementById("sync-qty");

// add to cart value must not exceed quantity in stock
function numberChanged()
{
  QTY.value = Math.max(Math.min(MAX_QUANTITY, QTY.value), 0);
  SYNC_QTY.value = QTY.value;
}

function addQty()
{
  var value = parseInt(QTY.value);
  QTY.value = value + 1;
  numberChanged();
}

function subtractQty()
{
  var value = parseInt(QTY.value);
  QTY.value = value - 1;
  numberChanged();
}

function addToCart()
{
  var value = parseInt(QTY.value);
  if (value != 0)
    return confirm(`Are you sure you want to add ${value} of this item to your cart?`);
  else
  {
    alert("There is nothing to add!");
    return false;
  }
}
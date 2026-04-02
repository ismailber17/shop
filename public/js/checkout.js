let cart = JSON.parse(localStorage.getItem("cart")) || [];

let orderItemsDiv = document.getElementById("orderItems");
let subtotal = 0;
let shipping = 0;
let deliveryType = "";

// 🟢 عرض المنتجات
function renderOrder() {
  orderItemsDiv.innerHTML = "";
  subtotal = 0;

  cart.forEach(item => {
    let price = Number(item.price.toString().replace(/[^\d]/g, ""));
    let quantity = Number(item.quantity) || 1;

    let total = price * quantity;
    subtotal += total;

    orderItemsDiv.innerHTML += `
      <div class="checkout-item">
        <span>${item.name} x${quantity}</span>
        <span>${total} دج</span>
      </div>
    `;
  });

  updateTotal();
}

// 🟢 تحديث السعر
function updateTotal() {
  document.getElementById("subtotal").innerText = subtotal + " دج";
  document.getElementById("shipping").innerText = shipping + " دج";
  document.getElementById("total").innerText = (subtotal + shipping) + " دج";
}


// 🟢 إرسال الطلب
function submitOrder() {
  let name = document.getElementById("name").value;
  let phone = document.getElementById("phone").value;
  let address = document.getElementById("address").value;
  let wilaya = document.getElementById("wilaya").selectedOptions[0]?.text;
  let commune = document.getElementById("commune").value;

  if (!name || !phone || !address || !wilaya || !commune || !deliveryType) {
    alert("يرجى ملء جميع المعلومات");
    return;
  }

  let order = {
    customer: { name, phone, address },
    delivery_type: deliveryType,
    wilaya: wilaya,
    commune: commune,
    shipping: shipping,
    items: cart,
    total: subtotal + shipping
  };

  fetch("http://localhost/shop/create_order.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(order)
  })
  .then(res => res.json())
  .then(data => {
    alert("تم إرسال الطلب بنجاح ✅");

    localStorage.removeItem("cart");
    window.location.href = "index.html";
  })
  .catch(err => {
    console.error(err);
    alert("خطأ في الطلب ❌");
  });
}

// 🟢 تشغيل
renderOrder();
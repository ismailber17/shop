let cart = JSON.parse(localStorage.getItem("cart")) || [];

function renderCart() {
  let cartItemsDiv = document.getElementById("cartItems");
  let subtotal = 0;
  let shippingEl = document.querySelector("#shipping");
  let shipping = shippingEl ? Number(shippingEl.value) : 0;

  cartItemsDiv.innerHTML = "";

  cart.forEach((item, index) => {
    let price = Number(item.price.toString().replace(/[^\d]/g, ""));
    let quantity = Number(item.quantity) || 1;

    let total = price * quantity;
    subtotal += total;

    cartItemsDiv.innerHTML += `
      <div class="cart-item">
        <img src="${item.image}">
        
        <div class="item-info">
          <h4>${item.name}</h4>
          <p>${price} دج</p>
        </div>

        <div class="qty-box">
          <button onclick="changeQty(${index}, -1)">-</button>
          <span>${quantity}</span>
          <button onclick="changeQty(${index}, 1)">+</button>
        </div>

        <div>${total} دج</div>

        <div class="delete" onclick="removeItem(${index})">🗑</div>
      </div>
    `;
  });

  document.getElementById("subtotal").innerText = subtotal + " دج";
  document.getElementById("total").innerText = subtotal + shipping + " دج";

  localStorage.setItem("cart", JSON.stringify(cart));
}

// 🟢 تعديل الكمية
function changeQty(index, change) {
  let shippingEl = document.querySelector("#shipping");
  let shipping = shippingEl ? Number(shippingEl.value) : 0;
  cart[index].quantity = (Number(cart[index].quantity) || 1) + change;

  if (cart[index].quantity <= 0) {
    cart.splice(index, 1);
  }
  localStorage.setItem("cart", JSON.stringify(cart));

  renderCart();
}

// 🟢 حذف
function removeItem(index) {
  cart.splice(index, 1);
  renderCart();
}

// تشغيل
renderCart();

console.log(cart);

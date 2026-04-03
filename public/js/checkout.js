let cart = JSON.parse(localStorage.getItem("cart")) || [];

let orderItemsDiv = document.getElementById("orderItems");
let subtotal = 0;
let shipping = 0;

function renderOrder() {
    orderItemsDiv.innerHTML = "";
    subtotal = 0;

    if (cart.length === 0) {
        orderItemsDiv.innerHTML = "<p>السلة فارغة</p>";
        return;
    }

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

function updateTotal() {
    document.getElementById("subtotal").innerText = subtotal + " دج";
    document.getElementById("shipping").innerText = shipping + " دج";
    document.getElementById("total").innerText = (subtotal + shipping) + " دج";
}

function submitOrder() {
    let name = document.getElementById("name").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let address = document.getElementById("address").value.trim();
    
    let wilayaSelect = document.getElementById("wilaya");
    let communeSelect = document.getElementById("commune");
    let deliverySelect = document.getElementById("deliveryType");

    let wilaya = wilayaSelect.options[wilayaSelect.selectedIndex]?.text;
    let commune = communeSelect.options[communeSelect.selectedIndex]?.text;
    let deliveryType = deliverySelect.value;

    if (!name || !phone || !address || !wilaya || !commune) {
        alert("يرجى ملء جميع المعلومات الأساسية");
        return;
    }

    let order = {
        customer: { name, phone, address },
        delivery_type: deliveryType,
        wilaya: wilaya,
        commune: commune,
        shipping: shipping,
        items: cart,
        total: subtotal + shipping,
        note: document.getElementById("note").value
    };

    fetch("http://localhost/shopIsmail/shop/create_order.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
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
        alert("خطأ في الاتصال بالخادم ❌");
    });
}

// تشغيل العرض الأولي
renderOrder();
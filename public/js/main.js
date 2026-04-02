let products = [];
let cart = JSON.parse(localStorage.getItem("cart")) || [];

const productsContainer = document.getElementById("products");
const cartCount = document.getElementById("cartCount");

// حماية من الأخطاء
if (!productsContainer) {
  console.error("❌ عنصر products غير موجود");
}

// جلب المنتجات مرة واحدة فقط
function fetchProducts() {
  fetch("http://localhost/shopIsmail/shop/get_products.php")
    .then(res => res.json())
    .then(data => {
      products = data;
      renderProducts();
      updateCartCount();
    })
    .catch(err => {
      console.error("❌ خطأ في جلب المنتجات:", err);
    });
}

function renderProducts() {

  if (!productsContainer) return;

  productsContainer.innerHTML = "";

  products.forEach(p => {

    const div = document.createElement("div");
    div.className = "product-card";

    div.innerHTML = `
      <img src="${p.image}" onerror="this.src='images/fallback.jpg'">
      <h3>${p.name}</h3>
      <p>${p.price} دج</p>
      <button onclick="addToCart(${p.id})">أضف للسلة</button>
    `;

    productsContainer.appendChild(div);

  });
}

function addToCart(id) {
  console.log("🟡 id:", id);
  console.log("📦 products:", products);

  const product = products.find(p => Number(p.id) === Number(id));

  console.log("🟢 product:", product);

  if (!product) {
    alert("❌ المنتج غير موجود");
    return;
  }

  const existing = cart.find(item => Number(item.id) === Number(id));

  if (existing) {
    existing.quantity++;
  } else {
    cart.push({ ...product, quantity: 1 });
  }

  console.log("🛒 cart:", cart);

  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();

  alert("✅ تمت الإضافة للسلة");
}

function updateCartCount() {
  if (!cartCount) return;

  const total = cart.reduce((sum, item) => sum + item.quantity, 0);
  cartCount.textContent = total;
}

// تشغيل مرة واحدة فقط
document.addEventListener("DOMContentLoaded", () => {
  fetchProducts();
  updateCartCount();

  document.querySelectorAll('.fade-up').forEach(el => {
    el.classList.add('show');
  });

  const loader = document.getElementById("loader");
  if (loader) loader.style.display = "none";
});

function revealOnScroll() {
  const elements = document.querySelectorAll(".reveal");

  elements.forEach(el => {
    const windowHeight = window.innerHeight;
    const elementTop = el.getBoundingClientRect().top;

    if (elementTop < windowHeight - 100) {
      el.classList.add("active");
    }
  });
}

window.addEventListener("scroll", revealOnScroll);

function renderProducts(category = "all") {

  productsContainer.innerHTML = "";

  let filtered = category === "all"
    ? products
    : products.filter(p => p.category === category);

  filtered.forEach(p => {

    const div = document.createElement("div");

    div.className = "product-card";

    div.innerHTML = `
      <img src="${p.image}">
      <h3>${p.name}</h3>
      <p>${p.price} دج</p>
      <button onclick="addToCart(${p.id})">أضف للسلة</button>
    `;

    productsContainer.appendChild(div);
  });
}
<?php
// ⚡️ إعداد الاتصال
$host = "localhost";
$user = "root";
$pass = ""; // إذا عندك password حطو هنا
$db   = "shop";

$conn = new mysqli($host, $user, $pass);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// إنشاء قاعدة البيانات إذا ما كانتش موجودة
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

// ================================
//  جدول المنتجات
// ================================
$sql_products = "
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT '',
    category VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if ($conn->query($sql_products) === TRUE) {
    echo "✅ جدول products جاهز<br>";
} else {
    echo "❌ خطأ في products: " . $conn->error . "<br>";
}

// ================================
//  جدول الطلبات
// ================================
$sql_orders = "
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    wilaya VARCHAR(100) NOT NULL,
    commune VARCHAR(100) NOT NULL,
    delivery_type VARCHAR(50) NOT NULL,
    shipping DECIMAL(10,2) DEFAULT 0,
    items JSON NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending','shipped','delivered') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if ($conn->query($sql_orders) === TRUE) {
    echo "✅ جدول orders جاهز<br>";
} else {
    echo "❌ خطأ في orders: " . $conn->error . "<br>";
}

$conn->close();
?>
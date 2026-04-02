<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

include "db.php";

// 🟢 قراءة البيانات
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// 🛑 حماية
if (!$data) {
  echo json_encode([
    "success" => false,
    "error" => "No data received",
    "raw" => $json
  ]);
  exit;
}

// 🟢 استخراج البيانات
$name = $data['customer']['name'] ?? '';
$phone = $data['customer']['phone'] ?? '';
$address = $data['customer']['address'] ?? '';
$wilaya = $data['wilaya'] ?? '';
$commune = $data['commune'] ?? '';
$total = $data['total'] ?? 0;

// 🟢 إدخال الطلب
$conn->query("INSERT INTO orders (name, phone, address, wilaya, commune, total)
VALUES ('$name','$phone','$address','$wilaya','$commune','$total')");

$order_id = $conn->insert_id;

// 🟢 إدخال المنتجات
if (!empty($data['items'])) {
  foreach ($data['items'] as $item) {
    $pname = $item['name'];
    $qty = $item['quantity'];
    $price = $item['price'];

    $conn->query("INSERT INTO order_items (order_id, product_name, quantity, price)
    VALUES ($order_id, '$pname', '$qty', '$price')");
  }
}

echo json_encode(["success" => true]);
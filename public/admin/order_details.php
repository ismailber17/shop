<?php include "../../db.php"; ?>

<?php
$id = $_GET['id'];

$order = $conn->query("SELECT * FROM orders WHERE id=$id")->fetch_assoc();
$items = $conn->query("SELECT * FROM order_items WHERE order_id=$id");
?>

<h2>تفاصيل الطلب</h2>

<p>الاسم: <?= $order['name'] ?></p>
<p>الهاتف: <?= $order['phone'] ?></p>
<p>الولاية: <?= $order['wilaya'] ?></p>
<p>البلدية: <?= $order['commune'] ?></p>
<p>العنوان: <?= $order['address'] ?></p>

<h3>المنتجات:</h3>

<ul>
<?php while($i = $items->fetch_assoc()) { ?>
  <li><?= $i['product_name'] ?> - <?= $i['quantity'] ?> × <?= $i['price'] ?></li>
<?php } ?>
</ul>
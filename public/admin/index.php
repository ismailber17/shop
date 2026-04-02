<?php include "../../db.php"; ?>
<?php include "auth.php"; ?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>لوحة التحكم</title>

<style>
body {
  font-family:Arial;
  background:#f4f4f4;
  padding:20px;
}

h2 {
  background:#222;
  color:#fff;
  padding:10px;
  border-radius:8px;
}

table {
  width:100%;
  border-collapse: collapse;
  margin-top:10px;
}

td,th {
  border:1px solid #ddd;
  padding:10px;
  text-align:center;
}

tr:nth-child(even) {
  background:#fafafa;
}

button {
  padding:8px 12px;
  background:gold;
  border:none;
  cursor:pointer;
  border-radius:5px;
}

form input, select {
  padding:8px;
  margin:5px;
}
</style>
</head>

<body>

<a href="logout.php" style="float:left;">🚪 تسجيل الخروج</a>

<h2>➕ إضافة منتج</h2>

<form action="add_product.php" method="POST">
  <input name="name" placeholder="اسم المنتج"><br><br>
  <input name="price" placeholder="السعر"><br><br>
  <input name="image" placeholder="رابط الصورة"><br><br>
  <select name="category">
  <option value="gypsum">ديكور جبس</option>
  <option value="resin">ديكور ريزين</option>
  <option value="epoxy">ديكور ريزين ايبوكسي</option>
</select>
  <button>إضافة</button>
</form>

<hr>

<h2>📦 المنتجات</h2>

<table>
<tr>
<th>الفئة</th>
<th>اسم</th>
<th>سعر</th>
<th>حذف</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM products");

while($row = $res->fetch_assoc()){
  echo "
  <tr>
    <td>{$row['category']}</td>
    <td>{$row['name']}</td>
    <td>{$row['price']}</td>
    <td><a href='delete_product.php?id={$row['id']}'>❌</a></td>
  </tr>";
}
?>

</table>

<hr>

<h2>🧾 الطلبات</h2>

<table>
<tr>
<th>الزبون</th>
<th>الهاتف</th>
<th>الولاية</th>
<th>المجموع</th>
<th>الحالة</th>
<th>تغيير</th>
<th>تفاصيل</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM orders ORDER BY id DESC");

while($o = $res->fetch_assoc()){
  echo "
  <tr>
    <td>{$o['name']}</td>
    <td>{$o['phone']}</td>
    <td>{$o['wilaya']}</td>
    <td>{$o['total']} دج</td>

    <td>".
      ($o['status']=='pending' ? '🟡 قيد المعالجة' :
      ($o['status']=='shipped' ? '🔵 تم الشحن' :
      ($o['status']=='delivered' ? '🟢 تم التوصيل' : '')))
    ."</td>

    <td>
      <form method='POST' action='update_status.php'>
        <input type='hidden' name='id' value='{$o['id']}'>

        <select name='status'>
          <option value='pending' ".($o['status']=='pending'?'selected':'').">قيد المعالجة</option>
          <option value='shipped' ".($o['status']=='shipped'?'selected':'').">تم الشحن</option>
          <option value='delivered' ".($o['status']=='delivered'?'selected':'').">تم التوصيل</option>
        </select>

        <button type='submit'>✔</button>
      </form>
    </td>

    <td>
      <a href='order_details.php?id={$o['id']}'>عرض</a>
    </td>

  </tr>";
}
?>

</table>

</body>
</html>

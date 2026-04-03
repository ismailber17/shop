<?php
include "db.php";

$id = $_GET['wilaya_id'];

$res = $conn->query("SELECT * FROM communes WHERE wilaya_id=$id");

$data = [];

while($row = $res->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode($data);
?>
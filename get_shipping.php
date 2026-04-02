<?php
include "db.php";

$id = $_GET['wilaya_id'];
$type = $_GET['type'];

$res = $conn->query("SELECT price FROM shipping WHERE wilaya_id=$id AND type='$type'");
$row = $res->fetch_assoc();

echo json_encode($row);
?>
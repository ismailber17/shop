<?php
include "../../db.php";

$id = $_POST['id'];
$status = $_POST['status'];

$conn->query("UPDATE orders SET status='$status' WHERE id=$id");

header("Location: index.php");
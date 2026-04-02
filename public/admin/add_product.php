<?php
include "../../db.php";

$name = $_POST['name'];
$price = $_POST['price'];
$image = $_POST['image'];
$category = $_POST['category'];
$conn->query("INSERT INTO products (name, price, image, category) 
VALUES ('$name','$price','$image','$category')");

header("Location: index.php");
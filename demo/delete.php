<?php
require 'model/product.php';
$id = $_GET['id'];
$product = new Product();
$product->select($id);
$product->delete();
header('Location: list.php');
?>

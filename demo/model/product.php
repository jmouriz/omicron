<?php
require 'database.php';

class Product extends ORM\Model {
   protected $columns = array('id', 'detail', 'price', 'stock');
   protected $table = 'products';
   protected $key = 'id';
}
?>

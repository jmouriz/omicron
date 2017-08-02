<?php
require '../model.php';

$string = 'sqlite:database/database.db';

class Product extends ORM\Model {
   protected $fields = array('id', 'detail', 'price', 'stock');
   protected $table = 'products';
   protected $key = 'id';
}
?>

<?php
require '../model.php';
$path = __DIR__;
ORM\connect("sqlite:$path/database/database.db");
?>

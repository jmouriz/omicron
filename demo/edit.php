<?php
require 'model/product.php';
$product = new Product();
$id = $_GET['id'];
$title = $id ? 'Editar producto' : 'Nuevo producto';
if (!empty($_POST)) {
   $product->id = $id;
   $product->detail = $_POST['detail'];
   $product->price = $_POST['price'];
   $product->stock = $_POST['stock'];
   $product->save();
   header('Location: list.php');
   exit;
} else {
   $product->select($id);
}
?>
<!doctype html>
<html lang="es">
   <head>
      <meta charset="utf-8" />
      <title><?php print $title; ?></title>
   </head>
   <body>
      <h1><?php print $title; ?></h1>
      <form method="post">
         <input required type="text" name="detail" placeholder="Detalle" value="<?php print $product->detail; ?>" /><br />
         <input type="number" name="price" placeholder="Precio" value="<?php print $product->price; ?>" /><br />
         <input type="number" name="stock" placeholder="Stock" value="<?php print $product->stock; ?>" /><br />
         <a href="list.php">Cancelar</a>
         <button type="submit">Guardar</button>
      </form>
   </body>
</html>

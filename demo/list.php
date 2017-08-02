<?php
require 'model/product.php';
$product = new Product();
?>
<!doctype html>
<html lang="es">
   <head>
      <meta charset="utf-8" />
      <title>Productos</title>
   </head>
   <body>
      <h1>Productos</h1>
      <table>
         <thead>
            <tr>
               <th>#</th>
               <th>Detalle</th>
               <th>Precio</th>
               <th>Stock</th>
               <th></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($product->all() as $key => $value): ?>
            <tr>
               <td><?php print $value->id; ?></td>
               <td><?php print $value->detail; ?></td>
               <td><?php print $value->price; ?></td>
               <td><?php print $value->stock; ?></td>
               <td><a href="edit.php?id=<?php print $value->id; ?>">Editar</a></td>
            </tr>
            <?php endforeach ?>
         </tbody>
      </table>
      <td><a href="edit.php">Agregar</a></td>
   </body>
</html>

<?php
require 'model/product.php';
$product = new Product();
$count = $product->count();
?>
<!doctype html>
<html lang="es">
   <head>
      <meta charset="utf-8" />
      <title>Productos</title>
      <style>
         span.red {
            color: red;
         }
      </style>
   </head>
   <body>
      <h1>Productos</h1>
      <p>
      <?php if ($count): ?>
         <?php print $count == 1 ? '1 producto encontrado' : "$count productos encontrados"; ?>
      <?php else: ?>
         <span class="red">No hay productos para mostrar</span>
      <?php endif ?>
      <p>
      <table>
         <thead>
            <tr>
               <th>#</th>
               <th>Detalle</th>
               <th>Precio</th>
               <th>Stock</th>
               <th colspan="2"></th>
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
               <td><a href="delete.php?id=<?php print $value->id; ?>">Eliminar</a></td>
            </tr>
            <?php endforeach ?>
         </tbody>
      </table>
      <p><a href="edit.php">Agregar</a></p>
   </body>
</html>

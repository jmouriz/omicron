<?php
require 'model/product.php';
$product = new Product();
$count = $product->count();
$page = array_key_exists('page', $_GET) ? $_GET['page'] : 1;
$limit = 5;
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

         .scroll {
            padding: 3px;
            margin: 6px;
            background-color: gray;
         }

         a.scroll {
            text-decoration: none;
            color: white;
         }

         span.scroll {
            color: darkgray;
            cursor: not-allowed;
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
      </p>
      <p><a href="edit.php">Agregar</a></p>
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
            <?php $rows = 1; ?>
            <?php foreach ($product->all($limit, $page) as $key => $value): ?>
            <tr>
               <td><?php print $value->id; ?></td>
               <td><?php print $value->detail; ?></td>
               <td><?php print $value->price; ?></td>
               <td><?php print $value->stock; ?></td>
               <td><a href="edit.php?id=<?php print $value->id; ?>">Editar</a></td>
               <td><a href="delete.php?id=<?php print $value->id; ?>">Eliminar</a></td>
            </tr>
            <?php $rows++; ?>
            <?php endforeach ?>
            <?php for ($row = $rows; $row <= $limit; $row++): ?>
            <tr><td colspan="7">&nbsp;</td></tr>
            <?php endfor ?>
         </tbody>
      </table>
      <?php if ($count > $limit): ?>
      <p>
         <?php if ($page > 1): ?>
         <a class="scroll" href="list.php?page=1">|&lt;&lt;</a>
         <a class="scroll" href="list.php?page=<?php print $page - 1; ?>">&lt;&lt;</a>
         <?php else: ?>
         <span class="scroll">|&lt;&lt;</span>
         <span class="scroll">&lt;&lt;</span>
         <?php endif ?>

         <?php if ($count > $page * $limit): ?>
         <a class="scroll" href="list.php?page=<?php print $page + 1; ?>">&gt;&gt;</a>
         <a class="scroll" href="list.php?page=<?php print ceil($count / $limit); ?>">&gt;&gt;|</a>
         <?php else: ?>
         <span class="scroll">&gt;&gt;</span>
         <span class="scroll">&gt;&gt;|</span>
         <?php endif ?>
      </p>
      <?php endif ?>
   </body>
</html>

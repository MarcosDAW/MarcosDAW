<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de cambios</title>
</head>
<body>
    <?php
    echo "<form action='index.php?editar=".$_GET['editar']."' method='POST'>";
    echo '<input type="text" name="titulo" placeholder="Nuevo Titulo">';
    echo '<input type="text" name="texto" placeholder="Nuevo Texto">';
    echo '<input type="submit">';
    echo "</form>";
    echo '<a href="index.php">Volver al Blog</a>';
    ?>    
</body>
</html>
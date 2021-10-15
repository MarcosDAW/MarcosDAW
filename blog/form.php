<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="styles.css">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de cambios</title>
</head>
<body>
    <?php
    echo "<div>"."<h1>Editar Articulo</h1>"."<form action='index.php?editar=".$_GET['editar']."' method='POST'>";
    echo '<input type="text" name="titulo" placeholder="Nuevo Titulo">';
    echo '<input type="text" name="texto" placeholder="Nuevo Texto">';
    echo '<input type="submit">';
    echo "</form>";
    echo "</div>";
    echo "<br>";
    echo '<a href="index.php">Volver al Blog</a>';
    ?>    

</body>
</html>
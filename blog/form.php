<!DOCTYPE html>
<html lang="en">
    <?php 
        $mysql = mysqli_connect("localhost", "root", "", "blog1");
        if($mysql->connect_error){
            echo "Fallo al conectar a MySQL";
        }
    ?>    
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de cambios</title>
</head>
<body>
    <?php
if( isset($_GET['editar']) ){
    
            echo '<form action="form.php" method="POST">';
            echo '<input type="text" name="titulo" placeholder="Titulo">';
            echo '<br>';
            echo '<input type="text" name="texto" placeholder="Texto">';
            echo '<input type="text" name="imagen" placeholder="Imagen">';
            echo '<br>';
            echo '<input type="submit" name="cambiar">';
            echo '</form>';
            
        }
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="style.css">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
</head>
<body>
    <form action="index.php?loged" method="POST">
        <h1>Inicio Sesión</h1>
        <div class="art">
            <input type="text" name="usuario" placeholder="Usuario">
            <br>
            <input type="text" name="password" placeholder="Contraseña">
            <br>
            <input type="submit">
            <br>
            <?php 
                if(!isset($_GET['loged'])){
                    echo "El usuario no existe";
                }
            ?>
            <h1><a href='index.php'>Peliculas</a></h1>
        </div>
    </form>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="styles.css">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        echo '<div>'.'<h1>Agregar articulo</h1>'.'<form action="index.php?agregar" method="POST">'.'
        <input type="text" name="titulo" placeholder="Titulo">'.'
        <input type="text" name="texto" placeholder="Texto">'.'
        <input type="submit">'.'
        </form>'.'
        <br>'.'
        <a href="index.php">Volver al Blog</a>'.'
        </div>';
    ?>
</body>
</html>
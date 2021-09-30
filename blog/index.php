<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php 
    $mysql = mysqli_connect("localhost", "root", "", "blog");
    if($mysql->connect_error){
        echo "Error al conectar";
    }else{
        echo 'conectado <br>';
    }
    
    /*
    
    */
    
    /*
    if(isset($_POST['insertar'])){
        $sql = "INSERT INTO articulos (titulo,texto,autor,fecha) VALUES (
            '".$_POST['titulo']."','".$_POST['texto']."','".$_POST['autor']."','".$_POST['fecha']."'
            )";
        $result = mysqli_query($mysql,$sql);
        echo "Datos Ingresados";
    }else{
        echo "no hay datos ingresados";
    }
    */
    if(isset($_POST['usuario']) && isset($_POST['contraseña'])){
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $sql = "SELECT nombre_usuario,contraseña FROM usuarios WHERE nombre_usuario = '$usuario' AND contraseña = '$contraseña'";
        $result = mysqli_query($mysql,$sql);
        if($result){
            if($row = mysqli_fetch_row($result)){
                $sql = "SELECT titulo,texto,autor,fecha,imagen FROM articulos";
                $result = mysqli_query($mysql,$sql);
                foreach($result as $rows){
                    echo '<h1>'.$rows['titulo'].'</h1>';
                    echo '<div>';
                    echo '<p>'.$rows['texto'].'</p>';
                    echo '<p>'.$rows['autor'].'</p>';
                    echo '<p>'.$rows['fecha'].'</p>';
                    echo '<img width=200px src="'.$rows['imagen'].'">';
                    echo '<hr>';
                    echo '</div>';
                }  
            }else{
                echo "usuario incorrecto";
            }
        }
    } 

?>
<body>
    <form action="index.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario">
        <br>
        <input type="text" name="contraseña" placeholder="Contraseña">
        <br>
        <input type="submit" name="ingresar" placeholder="Ingresar">
    </form>

    <form action="index.php" method="POST">
        <input type="text" name="titulo" placeholder="Titulo">
        <br>
        <input type="text" name="texto" placeholder="Texto">
        <br>
        <input type="text" name="autor" placeholder="Autor">
        <br>
        <input type="text" name="fecha" placeholder="00-00-00 00:00:00">
        <br>
        <input type="submit" name="insertar" placeholder="Insertar">
    </form>

</body>
</html>
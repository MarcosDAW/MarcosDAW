<!DOCTYPE html>
<html lang="en">
<?php 
    session_start();

    if(isset($_GET['logout'])){
        $_SESSION['loged']=false;
        session_destroy();
    }
    
    if(!isset($_SESSION['loged'])){
        $_SESSION['loged']=false;
    }
//------------Conectar BBDD-----------------    
    $mysql = mysqli_connect("localhost", "root", "", "blog");
    if($mysql->connect_error){
        echo "Fallo al conectar a MySQL";
    }
    //$loged=false;
    if(isset($_POST['usuario']) && isset($_POST['contraseña'])){
        //COMPROBAMOS SI HEMOS RESIVIDO $_POST
        $usuario =  $_POST['usuario'];
        $contraseña =  $_POST['contraseña'];
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$usuario'";
        $resultado = mysqli_query($mysql,$sql);
        // realizar la consulta select from users where nombre_usuario=post

       if($resultado){
           if($row = mysqli_fetch_row($resultado)){
               // si existe ese usuario comprobamos contraseña
               if( $row['contraseña'] == $_POST['contraseña'] ){
                   // si contraseña es correcta, echo OK
                   $_SESSION['loged']=true;
                   $_SESSION['usuario'] = $row['usuario'];
                   $_SESSION['id'] = $row['id'];
               }else $error = "Error en la contraseña";  
           }else $error="El usuario no existe";
       }
    }
    // borramos articulo
    if( $_SESSION['loged'] && isset($_GET['eliminar']) ){
        $result = $mysqli->query("DELETE FROM articulos WHERE id='".$_GET['eliminar']."'");
    }  
    // cargamos articulos
    $sql = "SELECT titulo,texto,autor,fecha,imagen FROM articulos";
    $resultado = mysqli_query($mysql,$sql);
    foreach($resultado as  $filas){
        echo '<h1>'.  $filas['titulo']. '</h1>';
        echo '<div>';
        echo '<p>'.  $filas['texto'].'</p>';
        echo '<p>'.  $filas['fecha'].'</p>';
        echo '<p>'.  $filas['autor'].'</p>';
        echo '<img width=200px src="'.  $filas['imagen'].'">';
        echo '<hr>';
        echo '</div>';
    } 
?>    
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>
<body>
    <?php
    echo "antes de decir hola: ".var_dump($_SESSION['loged']);

    if($_SESSION['loged']){
        echo "Hola ".$_SESSION['usuario'];
        echo " - <a href='index.php?logout'>Cerrar sesión</a>";
    }else{
        ?>
        <h3>Inicio Sesión</h3>
        <form action="index2.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" >
            <br>
            <input type="text" name="contraseña" placeholder="Contraseña" >
            <br>
            <input type="submit" value="Entrar" />
        </form>
        <?php 
        if( isset($error) ){
            echo "<h5>".$error."</h5>";
        }

        if( count($filas) ){
            foreach($resultado as  $filas){
                echo '<h1>'.  $filas['titulo']. '</h1>';
                echo '<div>';
                echo '<p>'.  $filas['texto'].'</p>';
                echo '<p>'.  $filas['fecha'].'</p>';
                echo '<p>'.  $filas['autor'].'</p>';
                echo '<img width=200px src="'.  $filas['imagen'].'">';
                echo '<hr>';
                echo '</div>';
            } 
            if($_SESSION['loged'] && $_SESSION['id'] == $filas['id']){
                echo "<a href='index.php?eliminar=".$filas['id']."'>Eliminar</a>";
            }
        }
    }
    ?>
</body>
</html>
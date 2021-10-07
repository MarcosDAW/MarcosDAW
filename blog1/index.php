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
    $mysql = mysqli_connect("localhost", "root", "", "blog1");
    if($mysql->connect_error){
        echo "Fallo al conectar a MySQL";
    }
    //$loged=false;
    if(isset($_POST['usuario']) && isset($_POST['contraseña'])){
        //COMPROBAMOS SI HEMOS RESIVIDO $_POST
        $sql = "SELECT * FROM usuarios WHERE usuario = '".$_POST['usuario']."'";
        // realizar la consulta select from users where nombre_usuario=post
       if($resultado = mysqli_query($mysql,$sql)){
           if($row = $resultado->fetch_assoc()){
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
        $sql = ("DELETE FROM articulos WHERE id_articulos='".$_GET['eliminar']."'");
        $result = mysqli_query($mysql,$sql);
    }  
//------------------------------EDITAR------------------------------------------------------
    if( $_SESSION['loged'] && isset($_GET['cambiar']) ){
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];
        $imagen = $_POST['imagen'];
        $sql = ("UPDATE articulos SET titulo ='$titulo' ,
         texto = '$texto' , imagen = '$imagen' WHERE id_articulo = '".$_GET['cambiar']."'");
        $result = mysqli_query($mysql,$sql);
    }
//------------------------------------------------------------------------------------------
    // cargamos articulos
    if ( $result = $mysql->query("SELECT * FROM articulos") )  
    while($row=$result->fetch_assoc()){
        $articles[] = $row;
    }
?>    
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog-actualizado</title>
</head>
<body>
    <?php
    if($_SESSION['loged']){
        echo "Bienvenido  [".$_SESSION['usuario']."]";
        echo "<a href='index.php?logout'>Cerrar sesión</a>";
    }else{
    ?>
        <h3>Inicio Sesión</h3>
        <form action="index.php" method="POST">
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
    }
    if(count($articles)){
        if( $_SESSION['loged'] && isset($_GET['editar']) ){
            ?>
            <form action="form.php" method="POST">
                <input type="text" name="titulo" placeholder="Titulo">
                <br>
                <input type="text" name="texto" placeholder="Texto">
                <input type="text" name="imagen" placeholder="Imagen">
                <br>
                <input type="submit" name="cambiar">
            </form>
            <?php
        }
        foreach($articles as $article){
            echo "<h2>".$article['titulo']."</h2>";
            echo "<div>";
            echo "<img src='".$article['imagen']."' width=150px />";
            echo "<p>".$article['texto']."</p>";
            echo "<p>Autor: ".$article['autor']." - el día ".$article['fecha'];
            if($_SESSION['loged'] && $_SESSION['usuario'] == $article['autor']){
                //----------------------------BOTON_EDITAR y BORRAR---------------------------//
                echo "<a href='index.php?eliminar = ".$article['id_articulos']."'>Eliminar</a> ";
                echo "<a href='form.php?action = ".$article['id_articulos']."'>Editar</a> ";
            }
            echo "</p>";
            echo "</div>";
        }
    }
    
    ?>
</body>
</html>
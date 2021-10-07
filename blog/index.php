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
        $sql = ("DELETE FROM articulos WHERE id_articulo='".$_GET['eliminar']."'");
        $result = mysqli_query($mysql,$sql);
    }  
/*------------------------------EDITAR------------------------------------------
    if( $_SESSION['loged'] && isset($_GET['editar']) ){
        $sql = ("UPDATE articulos SET titulo ='".$_GET['titulo']."' ,
         texto ='".$_GET['texto']."' , imagen='".$_GET['imagen']."' , autor='".$_GET['autor']."'");
        $result = mysqli_query($mysql,$sql);
    }
*/
//-----------------------------------------------------------------------------
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
    <title>Blog</title>
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
        foreach($articles as $article){
            echo "<h2>".$article['titulo']."</h2>";
            echo "<div>";
            echo "<img src='".$article['imagen']."' width=150px />";
            echo "<p>".$article['texto']."</p>";
            echo "<p>Autor: ".$article['autor']." - el día ".$article['fecha'];
            if($_SESSION['loged'] && $_SESSION['usuario'] == $article['autor']){
                echo "<a href='index.php?eliminar=".$article['id_articulo']."'>Eliminar</a> ";
            }
            /*-------------------------------EDITAR----------------------------------
            if($_SESSION['loged'] && $_SESSION['usuario'] == $article['autor']){
                echo "<a href='index.php?editar=".$article['id_articulo']."'>Editar</a> ";
            }
            */
            //-----------------------------------------------------------------------
            echo "</p>";
            echo "</div>";
        }
        
        
    }
    ?>
</body>
</html>
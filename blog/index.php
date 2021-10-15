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
           //echo <a href="crearArticulo.php">
       }
    }
// borramos articulo
    if( $_SESSION['loged'] && isset($_GET['eliminar']) ){
        $sql = ("DELETE FROM articulos WHERE id_articulo ='".$_GET['eliminar']."'");
        $result = mysqli_query($mysql,$sql);
    }  
//------------------------------EDITAR------------------------------------------------------

    if( $_SESSION['loged'] && isset($_GET['editar']) ){
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];
        $sql = ("UPDATE articulos SET titulo ='".$titulo."' ,
         texto = '".$texto."' WHERE id_articulo = '".$_GET['editar']."'");
        if($result = mysqli_query($mysql,$sql)){
            ?>
            <script>
                alert("EDITADO CORRECTAMENTE");
            </script>
            <?php
        }else{
            ?>
            <script>
                alert("NO SE HA EDITADO");
            </script>
            <?php
        }
    }
//-------------------------BOTON AGREGAR ARTICULO-------------------------------------------- 

        
    if( $_SESSION['loged'] && isset($_GET['agregar']) ){
        $titulo1 = $_POST['titulo'];
        $texto1 = $_POST['texto'];
        $sql = ("INSERT INTO articulos (titulo,texto,autor,imagen) VALUES(
            '".$titulo1."',
            '".$texto1."',
            '".$_SESSION['usuario']."',
            'imagen".$_SESSION['id'].".png'
            )");
        if($result = mysqli_query($mysql,$sql)){
            ?>
            <script>
                alert("AGREGADO CORRECTAMENTE");
            </script>
            <?php
        }else{
            ?>
            <script>
                alert("NO SE HA AGREGADO");
            </script>
            <?php
        }
    }

//------------------------------------------------------------------------------------------
    // cargamos articulos
    if ( $result = $mysql->query("SELECT * FROM articulos ORDER BY fecha DESC") )  
    while($row=$result->fetch_assoc()){
        $articles[] = $row;
    }
?>     
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog-actualizado</title>
</head>
<body>
    <?php
    if($_SESSION['loged']){
        echo " <br>";
        echo "Bienvenido  [".$_SESSION['usuario']."]";
        echo "<a href='index.php?logout'>Cerrar sesión</a>";
        echo "<a href='crearArticulo.php?agregar=".$_SESSION['usuario']."'>Agregar articulo</a>";
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
            echo "<h1>".$article['titulo']."</h1>";
            echo "<table>"."
                <tr>"."
                <div>"."
                <th>
                    <img src='".$article['imagen']."' width=150px />
                    <h2>".$article['autor']."</h2>
                </th>"."
                <th><p>".$article['texto']."</p></th>"."
                <th><h2>Fecha   ".$article['fecha']."</h2></th>"."
                </div>"."
                </tr>";
            if($_SESSION['loged'] && $_SESSION['usuario'] == $article['autor']){
                //----------------------------BOTON_EDITAR y BORRAR---------------------------//
                echo "<tr>"."
                    <th></th>"."
                    <th><a href='index.php?eliminar=".$article['id_articulo']."'>ELIMINAR</a></th>"."
                    <th><a href='form.php?editar=".$article['id_articulo']."'>EDITAR</a></th>"."
                </tr>";
            }
            echo "</table>";
        }
    }
    /*
    agregar un boton para agregar articulos
    agregar boton comentar articulo
    poder comentar un comentario
    designar roles de usuarios- 
    agregar el rol a la base de datos
    cuando inicia sesion guardar el $_SESSION['rol']
    rol = 2 --> Admin - puede borrar articulos y agregar articulos
    rol = 1 --> Usuario - maneja solo comentarios
    agregar boton me gusta en articulos y solo pueden dar 1 me gusta por articulo
    */
    ?>
</body>
</html>

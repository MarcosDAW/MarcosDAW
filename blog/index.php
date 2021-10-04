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
    //guarda todo lo que hace el usuario
    //es una variable de estado 
    
    session_start();

    if(!isset($_SESSION['loged'])){
        $_SESSION['loged']=false;
        echo "creo loged: ";
    }

    echo "antes de logear: ".var_dump($_SESSION['loged']);

    $mysql = mysqli_connect("localhost", "root", "", "blog");
    if($mysql->connect_error){
        echo "Error al conectar";
    }else{
        echo 'conectado <br>';
    }

    $loged=false;

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
         
         $usuario =  $_POST['usuario'];
         $contraseña =  $_POST['contraseña'];
         $sql = "SELECT nombre_usuario,contraseña FROM usuarios WHERE nombre_usuario = '$usuario' AND contraseña = '$contraseña'";
         $resultado = mysqli_query($mysql,$sql);
        if($resultado){
            if($row = mysqli_fetch_row($resultado)){
                 $_SESSION['loged']=true;
                 $_SESSION['usuario'] =  $_POST['usuario'];
                 echo "despues de logear: ".var_dump($_SESSION['loged']);
                 echo "<a href= 'index.php?logout'>Cerrar Sesión</a> ";
                 $sql = "SELECT titulo,texto,autor,fecha,imagen FROM articulos";
                 $resultado = mysqli_query($mysql,$sql);
                
                foreach($resultado as  $filas){
                    echo '<h1>'.  $filas['titulo']. '</h1>';
                    echo '<div>';
                    echo '<p>'.  $filas['texto'].'</p>';
                    echo '<p>'.  $filas['autor'].'</p>';
                    echo '<p>'.  $filas['fecha'].'</p>';
                    echo '<img width=200px src="'.  $filas['imagen'].'">';
                    echo '<hr>';
                    echo '</div>';
                    if( $_SESSION[ 'usuario' ] ==  $filas[ 'autor' ]){
                        
                        echo "< a href='index.php?eliminar'>Eliminar</a>";
                        if( isset($_GET['eliminar']) ){
                            $usuarioLogeado = $_SESSION['usuario'];
                            $sql = "DELETE FROM articulos WHERE autor = "'.$usuarioLogeado.';
                            $result = mysqli_query($mysql,$sql);
                            $row = mysqli_fetch_row($result);
                        }
                    }
                }  

                

                echo "<form action='index.php' method='POST'>";
                echo "input type='text' name='titulo' placeholder='Titulo'>";
                echo "<br>";
                echo "<input type='text' name='texto' placeholder='Texto'>";
                echo "<br>";
                echo "<input type='text' name='autor' placeholder='Autor'>";
                echo "<br>";
                echo "<input type='text' name='fecha' placeholder='00-00-00 00:00:00'>";
                echo "<br>";
                echo "<input type='submit' value='insertar'>";
                echo "</form>";
            }else{
                echo "usuario incorrecto";
            }
        }
    } 
    
?>
<?php
echo "antes de decir hola: ".var_dump($_SESSION['loged']);

if($_SESSION['loged']){
    echo "Hola ".$_SESSION['usuario'];
}else{
    echo "no estas logeado";
}
    
?>

<body>
    <form action="index.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario">
        <br>
        <input type="text" name="contraseña" placeholder="Contraseña">
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>

    


</body>
</html>
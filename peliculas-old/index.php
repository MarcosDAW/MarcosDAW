<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <?php
        /*Realizar una web que permita
        el registro/logeo de usuarios.
        El administrador puede publicar peliculas 
        {titulo, año, director,actores, cartel}
        Los usuarios pueden valorarlas una sola vez
        con "la recomiendo" o "no la recomiendo"*/

        //CONEXION BASE DE DATOS
        session_start();

        if( isset($_GET['logout']) ){
            $_SESSION['loged']=false;
            session_destroy();
        }

        if( !isset($_SESSION['loged']) ){
            $_SESSION['loged']=false;
        }

        $miConexion = mysqli_connect("localhost","root","","bbddpeliculas");

        if(!$miConexion){
            echo "fallo en la conexion";
        } 

        echo "<h1>"."<a href='registro.php'>Registrarse</a>"."</h1>";

        if( isset( $_GET[ 'registro' ] ) ){
            $sql = ("INSERT INTO usuarios (usuario,contraseña) VALUES (
                '".$_POST['usuario']."',
                '".$_POST['contraseña']."'
            )");
            $consulta = ("SELECT * FROM usuarios WHERE usuario = '".$_POST['usuario']."'");
            if($resultado = mysqli_query($miConexion,$consulta)){
                $row = mysqli_num_rows($resultado);
                if($row==0){
                    ?>
                    <script>
                        alert("Registro Correcto");
                    </script>
                    <?php
                    mysqli_query($miConexion,$sql);
                }else{
                    ?>
                    <script>
                        alert("Registro Incorreto");
                    </script>
                    <?php
                }
            }
        }
        $sql = ("SELECT * FROM peliculas");
        if($result = mysqli_query($miConexion,$sql)){
            while($row = $result->fetch_assoc()){
                $pelis[] = $row;
            }
        }

        echo "<h1>"."<a href='muestra.php'>Ver Peliculas</a>"."</h1>";
        
    ?>
    
</body>
</html>
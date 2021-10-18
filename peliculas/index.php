<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="style.css">
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
        //-----------------------INICIAR SESIÓN------------------------
        if(isset($_GET['loged'])){
            if( isset($_POST['usuario']) && isset($_POST['contraseña']) ){
                $sql = ("SELECT usuario,contraseña,rol,id FROM usuarios WHERE usuario ='".$_POST['usuario']."'");
                $result = mysqli_query($miConexion,$sql);
                if($row = $result->fetch_assoc()){
                    if($row['usuario'] == $_POST['usuario'] ){
                       if($row['contraseña'] == $_POST['contraseña']){
                           $_SESSION['loged'] = true;
                           $_SESSION['usuario'] = $row['usuario'];
                           $_SESSION['contraseña'] = $row['contraseña'];
                           $_SESSION['rol'] = $row['rol'];
                           $_SESSION1['id'] = $row['id'];
                       }else echo "Contraseña Incorrecta";
                    }
                }else{
                    echo "El usuario no existe";
                }
            }
        }
//-----------------------ENLACES-----------------------------
    ?>
        <div class='enlaces'>
        <div class='sesion'>
            <?php
            if($_SESSION['loged']){
                echo "<a href='index.php?logout'>Cerrar Sesión</a>";
                echo "Bienvenido ".$_SESSION['usuario'];
            }else{
                echo"
                <a href='login.php?loged'>Iniciar Sesión</a>"."
                <img src='login.png' width='25px'>"."
                <br>"."
                <a href='registro.php'>Registrarse</a>";
            } 
            ?>    
        </div>
        </div>
    <?php
        //--------------------CREAR REGISTRO-------------------------
        if( isset( $_GET[ 'registro' ] ) ){
            $sql = ("INSERT INTO usuarios (usuario,contraseña,rol) VALUES (
                '".$_POST['usuario']."',
                '".$_POST['contraseña']."',
                'usuario')");

            $consulta = ("SELECT * FROM usuarios WHERE usuario = '".$_POST['usuario']."'");
            if($resultado = mysqli_query($miConexion,$consulta)){
                
                if($row = mysqli_num_rows($resultado)>0){
                    echo "el usuario ya existe";
                }else{
                    mysqli_query($miConexion,$sql);
                    echo "registro correcto";
                }
            }
        }
        $sql = ("SELECT * FROM peliculas");
        if($result = mysqli_query($miConexion,$sql)){
            while($row = $result->fetch_assoc()){
                $pelis[] = $row;
            }
        }
        //---------------------AÑADIR PELICULA-----------------------
        if($_SESSION['loged'] && $_SESSION['rol']=='admin'){
            echo "<a href='añadir.php'>Añadir Pelicula</a>";
        }
        if($_SESSION['loged'] && isset($_GET['add'])){
            $sql = ("INSERT INTO peliculas(titulo,año,director,actor,cartel) VALUES 
            ('".$_POST['titulo']."',
            '".$_POST['año']."',
            '".$_POST['director']."',
            '".$_POST['actor']."',
            '".$_POST['cartel']."')");
            if($result = mysqli_query($miConexion,$sql)){
                echo "<h1>Agregada correctamente</h1>";
            }else{
                echo "<h1>Error al agregar</h1>";
            }
        }
        //---------------------MOSTRAR PELICULAS---------------------
        if(count($pelis)){
            foreach( $pelis as $pelicula ){
                echo"<div class='peliculas'>"."
                        <div class='titulo'>
                            <h1>".$pelicula['titulo']."</h1>"."
                            <div class='cartel'>"."
                                <img width='100px' src='".$pelicula["cartel"]."'>"."
                            </div>"."
                        </div>"."

                        <div class='descripcion'>"."   
                            <h3>Año: ".$pelicula['año']."</h3>"."
                            <h3>Director: ".$pelicula['director']."</h3>"."
                            <h3>Actor: ".$pelicula['actor']."</h3>"."
                        </div>";

                        if($_SESSION['loged'] && $_SESSION['rol']=='usuario'){
                            echo    
                            "<div class='me-gusta'>"."
                                <h3></h3>"."
                                <a href='index.php?megusta=".$pelicula['id_pelicula']."'>"."<img src='megusta.png' width='60px' >"."</a>"."
                            </div>"."

                            <div class='no-gusta'>"."
                                <h3></h3>"."
                                <a href='index.php?nogusta=".$pelicula['id_pelicula']."'>"."<img src='nogusta.png' width='60px' >"."</a>"."
                            </div>";
                        }
                    echo "</div>";
            }
        }
        if($_SESSION['loged'] && $_SESSION['rol']=="usuario"){
            if(isset($_GET['megusta']) || isset($_GET['nogusta'])){
                $sql1 = ("INSERT INTO peliculas (megusta) VALUES ('1') WHERE id_pelicula = '".$_GET['megusta']."'");
                $sql2= ("INSERT INTO peliculas (nogusta) VALUES ('1') WHERE id_pelicula = '".$_GET['nogusta']."'");
                if(isset($_GET['megusta'])){
                    if($result1 = mysqli_query($miConexion,$sql1)){
                        if($row1 = $result1->fetch_assoc()){
                            $megusta = $row1['megusta'];
                            echo "<h3>'".$megusta."'</h3>";
                        }
                    } 
                }else if(isset($_GET['nogusta'])){
                    if($result2 = mysqli_query($miConexion,$sql2)){
                        if($row2 = $result2->fetch_assoc()){
                            $nogusta = $row2['nogusta'];
                            echo "<h3>$nogusta</h3>";
                        }
                    }
                }
            }
            
        }
        
            
    ?>    
</body>
</html>
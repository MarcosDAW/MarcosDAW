<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="style.css">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
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
            if( isset($_POST['usuario']) && isset($_POST['password']) ){
                $sql = ("SELECT usuario,password,rol,id FROM usuarios WHERE usuario ='".$_POST['usuario']."'");
                if($result = mysqli_query($miConexion,$sql)){
                    if($row = $result->fetch_assoc()){
                        if($row['usuario'] == $_POST['usuario'] ){
                           if($row['password'] == $_POST['password']){
                               $_SESSION['loged'] = true;
                               $_SESSION['usuario'] = $row['usuario'];
                               $_SESSION['password'] = $row['password'];
                               $_SESSION['rol'] = $row['rol'];
                               $_SESSION['id'] = $row['id'];
                           }else echo "password Incorrecta";
                        }
                    }else{
                        echo "El usuario no existe";
                    }
                }
                
            }
        }

        if($_SESSION['loged'] && $_SESSION['rol']=="usuario"){
            if(isset($_GET['megusta']) || isset($_GET['nogusta'])){
                $sql1 = ("INSERT INTO peliculas (megusta) VALUES ('1') WHERE id_pelicula = '".$_GET['megusta']."'");
                $sql2 = ("INSERT INTO peliculas (nogusta) VALUES ('1') WHERE id_pelicula = '".$_GET['nogusta']."'");
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

        //--------------------CREAR REGISTRO-------------------------
        if( isset( $_GET[ 'registro' ] ) ){
            $sql = ("INSERT INTO usuarios (usuario,password,rol) VALUES (
                '".$_POST['usuario']."',
                '".$_POST['password']."',
                'usuario')");

            $consulta = ("SELECT * FROM usuarios WHERE usuario = '".$_POST['usuario']."'");
            if($resultado = mysqli_query($miConexion,$consulta)){
                if($row = mysqli_num_rows($resultado)>0){
                    echo "el usuario ya existe";
                }else{
                    mysqli_query($miConexion,$sql);
                    echo "registro correcto";
                    $valores = $valor->fetch_assoc();
                    //$miConexion->query("INSERT INTO valoraciones (iduser) VALUES ('".$sql.']."')");
                    //como sacar el id ingresado dl usuario
                }
            }
        }
        //-----------------------Cargar iduser----------------------
            if($result = $miConexion->query("SELECT id FROM usuarios")){
                $contador=1;
                while($row = $result->fetch_assoc()){
                    $miConexion->query("UPDATE valoraciones SET iduser = '".$row['id']."' WHERE id = '".$contador."'");
                    $contador++;
                }
                
            }
        //---------------------AÑADIR PELICULA-----------------------
        if($_SESSION['loged'] && $_SESSION['rol']=='admin'){
            echo "<a href='add.php'>Añadir Pelicula</a>";
        }
        if($_SESSION['loged'] && isset($_GET['add'])){
            $sql = ("INSERT INTO peliculas(titulo,año,director,actor,cartel) VALUES 
            ('".$_POST['titulo']."',
            '".$_POST['año']."',
            '".$_POST['director']."',
            '".$_POST['actor']."',
            '".$_POST['cartel']."')");
            if($result = mysqli_query($miConexion,$sql)){
                echo "<p>Agregada correctamente</p>";
                if(isset($pelis)){
                    $result = $miConexion->query("INSERT INTO valoraciones (idpeli) VALUES ('".$pelis['id_pelicula']."')");
                }
            }else{
                echo "<p>Error al agregar</p>";
            }
        }
        //-----------------CARGAMOS LAS PELICULAS----------------------
        if($result = $miConexion->query("SELECT * FROM peliculas") ){
            if($cantidad = mysqli_num_rows($result)>0){
                while($row = $result->fetch_assoc()){
                    $pelis[] = $row;
                }
            } 
        }else{
            echo "<p>no hay peliculas</p>";
        }
    ?>
</head>
<body>
    <!-------------------------ENLACES----------------------------->
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
        //---------------------MOSTRAR PELICULAS---------------------
        if(isset($pelis)){
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
        }else{
            echo "<div>"."<p>No hay peliculas</p>"."</div>";
        }
        
    ?>    
</body>
</html>
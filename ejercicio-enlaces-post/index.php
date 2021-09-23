<html>
    <head>
        <title>URL con números</title>
    </head>
    <body>
 
        
        <?php

            $usuarios[ 0 ][ 'username' ] = "admin" ;
            $usuarios[ 0 ][ 'password' ] = "00000" ;
            $usuarios[ 1 ][ 'username' ] = "usuario1" ;
            $usuarios[ 1 ][ 'password' ] = "11111" ;
            $usuarios[ 2 ][ 'username' ] = "usuario2" ;
            $usuarios[ 2 ][ 'password' ] = "22222" ;
            
            if(isset($_POST['username']) && isset($_POST['password'])){
                /*PROBAR A VER SI FUNCIONA
                for ($i=0;$i<count($usuarios);$i++  ){
                    if($_POST['username'] == $usuario[$i]['username']){
                        if($_POST['password'] == $usuario[$i]['password']){
                            echo "correcto";
                        }
                    }
                }
                */
                foreach( $usuarios as $usuario ){
                    if(isset($_POST['password']) && $_POST['password'] == $usuario['password'] ){
                        echo "Ingreso correcto";
                        break;
                    }else{
                        echo "el usuario no existe";
                    }
                }
            }

            /*
            $url [0] ['url']= "www.google.com";
            $url [1] ['url']= "www.youtube.com";
            $url [2] ['url']= "www.wiki.com";

            $url [0] ['img']= "imagen1.png";
            $url [1] ['img']= "imagen2.png";
            $url [2] ['img']= "imagen3.png";
            $contador = 0;
            
            foreach ( $url as $urls ) {
                echo '<a href="'.$urls['url'].'"> <img src="'.$urls['img'].'" width=100px> </a> <br>';
            }
            
            
            if (isset($_GET['id']) && $_GET['id']<count($url) && $_GET['id']>-1){
                echo '<a href="'.$url[$_GET['id']]['url'].'"><img src="'.$url[$_GET['id']]['img'].'"></h1>';
            }else{
                echo '<h1>No hay id</h1>';
            }
            */
            
        ?>
            <p>Formulario con tipo texto GET</p>
            <form method = "GET" action = "index.php">
                <input type="text" name="nombre">
                <input type="submit" name="enviar">
                <br>
                <input type="submit" name="id" value="1">
                <input type="submit" name="id" value="2">
                <input type="submit" name="id" value="3">
            </form>
            
            <p>Formulario con tipo texto POST</p>
            <form method = "POST" action = "index.php">
                <input type="text" name="username" placeholder="username">
                <br>
                <input type="text" name="password" placeholder="pasword">
                <input type="submit">
            </form>
            
            
    </body>
</html>
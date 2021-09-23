<html>
    <head>
        <title>prueba</title>
    </head>
    <body>
        <?php
            $imagenes[]="imagen1.png";
            $imagenes[]="imagen2.png";
            $imagenes[]="imagen3.png";
            foreach($imagenes as $imagen){
                echo '<img src='.$imagen.' width=200px ><br>';
            }
        ?>
    </body>
</html>

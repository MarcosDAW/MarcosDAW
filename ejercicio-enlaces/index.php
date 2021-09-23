<html>
    <head>
        <title>URL con números</title>
    </head>
    <body>
        
        <?php
            $url [0] ['url']= "www.google.com";
            $url [1] ['url']= "www.youtube.com";
            $url [2] ['url']= "www.wiki.com";

            $url [0] ['img']= "imagen1.png";
            $url [1] ['img']= "imagen2.png";
            $url [2] ['img']= "imagen3.png";
            $contador = 0;
            /* 
            foreach ( $url as $urls ) {
                echo '<a href="'.$urls['url'].'"> <img src="'.$urls['img'].'" width=100px> </a> <br>';
            }
            */

            if (isset($_GET['id']) && $_GET['id']<count($url) && $_GET['id']>-1){
                echo '<a href="'.$url[$_GET['id']]['url'].'"><img src="'.$url[$_GET['id']]['img'].'"></h1>';
            }else{
                echo '<h1>No hay id</h1>';
            }
        ?>
        
        
    </body>
</html>
<form action="index.php" method="POST">
    <input type="text" name="titulo" placeholder="Titulo" >
    <br>
    <input type="text" name="texto" placeholder="Texto" >
    <br>
    <input type="text" name="imagen" placeholder="Imagen.png" >
    <br>
    <input type="text" name="autor" placeholder="Autor" >
    <br>
</form>
<?php 
if($_SESSION['loged'] && $_SESSION['usuario'] == $article['autor']){
    echo "<a href='index.php=".$article['id_articulo']."'>guardar cambios</a> ";
}
?>

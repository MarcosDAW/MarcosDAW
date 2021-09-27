<?php
    $mysql = mysqli_connect("localhost", "root", "", "phpmarcos");
    if($mysql->connect_error){
        echo "Error al conectar";
    }else{
        echo 'conectado<br>';
    }
    /*
    $sql = "SELECT username,password,name FROM users";
    $result = mysqli_query($mysql, $sql);
    if ($result){
        $row = mysqli_fetch_row($result);
    }
    */
    $sql = "SELECT username,password FROM users WHERE username = '".$_POST['username']."' AND password ='".$_POST['password']."' ";
    $result = mysqli_query($mysql,$sql);
    if($result){
        if($row = mysqli_fetch_row($result)){
            echo "contraseña correcta";
        }else{
            echo "contraseña incorrecta";
        }
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method = "POST" action = "index.php">
                <input type="text" name="username" placeholder="username">
                <br>
                <input type="text" name="password" placeholder="pasword">
                <br>
                <input type="submit">
            </form>
</body>
</html>
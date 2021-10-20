<?php
    class Movie{
        private $id;
        private $titulo;
        private $año;
        private $cartel;

        /*creamos inicio de sesion con el usuario y
        el usuario va a ser un objeto usando contructor
        1-crear la clase menos contraseña
        2-hacer el login dentro del constructor recibe un usuario y una contraseña
        si es correcta guardamos datos sino damos un error
        */
        //constructor recibe array asociativo desde fetch_assoc
        public function __construct($row){
            $this->id=$row['id'];
            $this->titulo=$row['titulo'];
            $this->año=$row['año'];
            $this->cartel=$row['cartel'];
        }
        public function getTitle(){
            return $this->titulo;
        }

    }
?>
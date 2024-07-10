<?php

class Articulo {

    private $conn;
    private $table = 'articulos';

    // Propiedades
    public $id;
    public $titulo;
    public $imagen;
    public $texto;
    public $fecha_creacion;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Obtener los artículos
    public function leer(){
        //Crear query
        $query = 'SELECT id, titulo, imagen, texto, fecha_creacion FROM ' . $this->table;

        //Preparar sentencia
        $stmt = $this->conn->prepare($query);

        //Ejecutar query
        $stmt->execute();
        $articulos = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $articulos;
    }

    //Obtener los artículos
    public function leer_individual($id){
        //Crear query
        $query = 'SELECT id, titulo, imagen, texto, fecha_creacion FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1 ';

        //Preparar sentencia
        $stmt = $this->conn->prepare($query);

        // Vincular parametro
        $stmt->bindParam(1, $id);

        //Ejecutar query
        $stmt->execute();
        $articulo = $stmt->fetch(PDO::FETCH_OBJ);
        return $articulo;
    }


}
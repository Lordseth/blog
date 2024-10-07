<?php

class Comentario {

    private $conn;
    private $table = 'comentarios';

    // Propiedades
    public $id;
    public $comentario;
    public $estado;
    public $fecha_creacionnn;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Obtener los usuarios
    public function leer(){
        //Crear query
        $query = 'SELECT c.id AS id_comentario, c.comentario AS comentario, c.estado AS estado, c.fecha_creacionnn AS fecha, c.usuario_id, u.email AS nombre_usuario, a.titulo AS titulo_articulo  FROM ' . $this->table . ' c LEFT JOIN usuarios u ON u.id = c.usuario_id LEFT JOIN articulos a ON a.id = c.articulo_id';

        //Preparar sentencia
        $stmt = $this->conn->prepare($query);

        //Ejecutar query
        $stmt->execute();
        $comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $comentarios;
    }

    //Obtener usuario individual
    public function leer_individual($id){
        //Crear query
        $query = 'SELECT c.id AS id_comentario, c.comentario AS comentario, c.estado AS estado, c.fecha_creacionnn AS fecha, c.usuario_id, u.email AS nombre_usuario, a.titulo AS titulo_articulo  FROM ' . $this->table . ' c LEFT JOIN usuarios u ON u.id = c.usuario_id LEFT JOIN articulos a ON a.id = c.articulo_id WHERE c.id = ? LIMIT 0,1';

        //Preparar sentencia
        $stmt = $this->conn->prepare($query);

        // Vincular parametro
        $stmt->bindParam(1, $id);

        //Ejecutar query
        $stmt->execute();
        $comentario = $stmt->fetch(PDO::FETCH_OBJ);
        return $comentario;
    }

     //Crear un articulo
     public function crear($titulo, $newImageName, $texto){
        //Crear query
        $query = 'INSERT INTO ' . $this->table . ' (titulo, imagen, texto)VALUES(:titulo, :imagen, :texto) ';

        //Preparar sentencia
        $stmt = $this->conn->prepare($query);

        // Vincular parametro
        $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $newImageName, PDO::PARAM_STR);
        $stmt->bindParam(":texto", $texto, PDO::PARAM_STR);

        //Ejecutar query
        if ($stmt->execute()) {
            return true;
        }

        // Si hay error
        printf("error \n", $stmt->error);
        
    }

     //Actualizar un articulo
     public function actualizar($idUsuario, $rol){

       
            //Crear query
            $query = 'UPDATE ' . $this->table . ' SET rol_id = :rol_id WHERE id = :id  ';

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(":rol_id", $rol, PDO::PARAM_INT);
            $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);

            //Ejecutar query
            if ($stmt->execute()) {
                return true;
            }
            

            // Si hay error
            printf("error \n", $stmt->error);

     }

    //Borrar un articulo
    public function borrar($idUsuario){
        //Crear query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id ';

        //Preparar sentencia
        $stmt = $this->conn->prepare($query);

        // Vincular parametros
        $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);

        //Ejecutar query
        if ($stmt->execute()) {
            return true;
        }

        // Si hay error
        printf("error \n", $stmt->error);
        
    }


}
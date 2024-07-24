<?php

class Usuario {

    private $conn;
    private $table = 'usuarios';

    // Propiedades
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $fecha_creacionn;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Obtener los usuarios
    public function leer(){
        //Crear query
        $query = 'SELECT u.id AS usuario_id, u.nombre AS usuario_nombre, u.email AS usuario_email, u.fecha_creacionn AS usuario_fecha_creacionn, r.nombre AS rol  FROM ' . $this->table . ' u INNER JOIN roles r ON r.id = u.rol_id';

        //Preparar sentencia
        $stmt = $this->conn->prepare($query);

        //Ejecutar query
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    //Obtener usuario individual
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
     public function actualizar($id, $titulo, $texto, $newImageName){

        if ($newImageName == "") {
            //Crear query
            $query = 'UPDATE ' . $this->table . ' SET titulo = :titulo, texto = :texto WHERE id = :id  ';

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            // Vincular parametro
            $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);
            $stmt->bindParam(":texto", $texto, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            //Ejecutar query
            if ($stmt->execute()) {
                return true;
            }
            }else {
                 //Crear query
                $query = 'UPDATE ' . $this->table . ' SET titulo = :titulo, texto = :texto, imagen = :imagen WHERE id = :id  ';

                //Preparar sentencia
                $stmt = $this->conn->prepare($query);

                // Vincular parametro
                $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);
                $stmt->bindParam(":texto", $texto, PDO::PARAM_STR);
                $stmt->bindParam(":imagen", $newImageName, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                

                //Ejecutar query
                if ($stmt->execute()) {
                    return true;
                }
            }

            // Si hay error
            printf("error \n", $stmt->error);
        
    }

    //Borrar un articulo
    public function borrar($idArticulo){
        //Crear query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id ';

        //Preparar sentencia
        $stmt = $this->conn->prepare($query);

        // Vincular parametro
        $stmt->bindParam(":id", $idArticulo, PDO::PARAM_INT);

        //Ejecutar query
        if ($stmt->execute()) {
            return true;
        }

        // Si hay error
        printf("error \n", $stmt->error);
        
    }


}
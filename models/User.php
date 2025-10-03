<?php
require_once __DIR__ . "/../config/db.php";

class User
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Listar usuarios
    public function getAll()
    {
        //solo mostrara los usuarios con estado 1 (activo)
        $sql = "SELECT * FROM usuarios WHERE estado = 1 ORDER BY nombres ASC";
        $result = $this->conn->query($sql);
        return $result;
    }


    // Crear usuario
    public function create($nombres, $apellidos, $telefono, $email)
    {
        // Validaciones simples en PHP
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}$/", $nombres)) return false;
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}$/", $apellidos)) return false;
        if (!preg_match("/^[0-9]{7,15}$/", $telefono)) return false;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

        // Chequeo duplicados
        if ($this->emailExists($email)) return false;

        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombres, apellidos, telefono, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombres, $apellidos, $telefono, $email);
        return $stmt->execute();
    }


    // Obtener usuario por ID
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Actualizar usuario
    public function update($id, $nombres, $apellidos, $telefono, $email)
    {
        // Validaciones
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}$/", $nombres)) return false;
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}$/", $apellidos)) return false;
        if (!preg_match("/^[0-9]{7,15}$/", $telefono)) return false;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

        // Chequeo duplicados excluyendo el propio
        if ($this->emailExistsExcept($email, $id)) return false;

        $stmt = $this->conn->prepare("UPDATE usuarios 
                                  SET nombres=?, apellidos=?, telefono=?, email=?, fecha_ultima_modificacion=NOW() 
                                  WHERE id=?");
        $stmt->bind_param("ssssi", $nombres, $apellidos, $telefono, $email, $id);
        return $stmt->execute();
    }


    // Eliminar usuario
    public function delete($id)
    {
        //cambiamos el estado de 1 (activo) a 0 (inactivo)
        $stmt = $this->conn->prepare("UPDATE usuarios SET estado = 0 WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    // Verificar si el email ya existe
    public function emailExists($email)
    {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Verificar duplicado excluyendo el mismo usuario (para editar)
    public function emailExistsExcept($email, $id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email=? AND id<>?");
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    //Verificar duplicado de telefono movil
    public function telefonoExists($telefono)
    {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE telefono=?");
        $stmt->bind_param("s", $telefono);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    // Verificar duplicado excluyendo el mismo usuario (para editar)
    public function telefonoExistsExcept($email, $id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE telefono=? AND id<>?");
        $stmt->bind_param("si", $telefono, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}

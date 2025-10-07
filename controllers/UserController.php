<?php
require_once __DIR__ . "/../models/User.php";

class UserController
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $db = new Database();
        $conn = $db->getConnection();

        // Capturar búsqueda si existe
        $busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

        if ($busqueda != '') {
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombres LIKE ? AND estado = 1 ORDER BY nombres ASC");
            $like = "%$busqueda%";
            $stmt->bind_param("s", $like);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $sql = "SELECT * FROM usuarios WHERE estado = 1 ORDER BY nombres ASC";
            $result = $conn->query($sql);
        }
        $usuarios = $result;

        include "views/list.php"; //vista principal
    }


    public function create($nombres, $apellidos, $telefono, $email)
    {
        return $this->model->create($nombres, $apellidos, $telefono, $email);
    }

    public function edit($id)
    {
        return $this->model->getById($id);
    }

    public function update($id, $nombres, $apellidos, $telefono, $email)
    {
        return $this->model->update($id, $nombres, $apellidos, $telefono, $email);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }
}

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
        $usuarios = $this->model->getAll();
        include __DIR__ . "/../views/list.php";
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

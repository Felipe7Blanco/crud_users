<?php
require_once __DIR__ . "/../controllers/UserController.php";

$controller = new UserController();
$id = $_GET["id"] ?? null;

if ($id) {
    if ($controller->delete($id)) {
        header("Location: ../index.php?deleted=1");
        exit;
    } else {
        echo "❌ Error al eliminar el usuario.";
    }
} else {
    header("Location: ../index.php");
    exit;
}

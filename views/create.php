<?php
require_once __DIR__ . "/../controllers/UserController.php";
//esta clase es para crear usuarios.
$controller = new UserController();
//verficamos los datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombres   = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $telefono  = $_POST["telefono"];
    $email     = $_POST["email"];
    //respuesta positiva
    if ($controller->create($nombres, $apellidos, $telefono, $email)) {
        header("Location: ../index.php?success=1");
        exit;
        //espuesta negativa
    } else {
        $error = "❌ Error: Verifique los datos o que el correo no esté duplicado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        /**estructura de la pagina  */
        body {
            background: url("./assets/img/logo.png") no-repeat center center fixed;
            /**imagen de fondo */
            background-size: contain;
            background-attachment: fixed
        }

        .main-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-between">
            <span class="navbar-brand mb-0 h1">CRUD Usuarios</span>
            <a href="https://github.com/TU-USUARIO/TU-REPO" target="_blank" class="btn btn-outline-light">🌐 GitHub</a>
        </div>
    </nav>

    <div class="container main-container">
        <h2 class="text-center mb-4">Crear Usuario</h2>
        <a href="../index.php" class="btn btn-secondary mb-3">⬅ Volver</a>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" name="nombres" id="nombres" class="form-control" required pattern="^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}$">
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control" required pattern="^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}$">
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" required pattern="^[0-9]{7,15}$">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">💾 Guardar</button>
        </form>
    </div>
</body>

</html>
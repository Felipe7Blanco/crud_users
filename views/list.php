<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CRUD Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
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

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-between">
            <span class="navbar-brand mb-0 h1">CRUD Usuarios</span>
            <a href="https://github.com/TU-USUARIO/TU-REPO" target="_blank" class="btn btn-outline-light">🌐 Ver en GitHub</a>
        </div>
    </nav>

    <div class="container main-container">
        <h1 class="text-center mb-4">Listado de Usuarios</h1>
        <div class="d-flex justify-content-end mb-3">
            <a href="views/create.php" class="btn btn-primary">➕ Nuevo Usuario</a>
        </div>

        <!-- Alertas -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ Usuario creado correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                ✏️ Usuario actualizado con éxito.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                🗑 Usuario eliminado correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Fecha Registro</th>
                        <th>Última Modificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($usuarios->num_rows > 0): ?>
                        <?php while ($row = $usuarios->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= $row["nombres"] ?></td>
                                <td><?= $row["apellidos"] ?></td>
                                <td><?= $row["telefono"] ?></td>
                                <td><?= $row["email"] ?></td>
                                <td><?= $row["fecha_registro"] ?></td>
                                <td><?= $row["fecha_ultima_modificacion"] ?></td>
                                <td>
                                    <a href="views/edit.php?id=<?= $row["id"] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                                    <a href="views/delete.php?id=<?= $row["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar este usuario?');">🗑 Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No hay usuarios registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
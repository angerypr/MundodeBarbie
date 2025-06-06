<?php
include('../libreria/plantilla.php');
plantilla::aplicar();
$archivoProfesiones = 'profesiones.json';
$profesiones = file_exists($archivoProfesiones)
    ? json_decode(file_get_contents($archivoProfesiones), true)
    : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Profesiones</title>

    <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        h2.titulo {
            font-family: 'Pattaya', sans-serif;
            color: #ff69b4;
            font-size: 2.8rem;
            text-shadow: 2px 2px #ffc0cb;
        }

        body {
            background-color: rgb(248, 234, 239);
            background-image: radial-gradient(circle, rgb(239, 201, 219) 1.5px, transparent 1.5px);
            background-size: 30px 30px;
        }

        .btn-custom {
            background-color: rgb(218, 64, 141);
            border: none;
            color: white;
        }

        .btn-custom:hover {
            background-color: #ff85c1;
            color: rgb(233, 195, 214);
        }

        .table-custom {
            background-color: #fff0f5;
            border: 2px solid #ffb6c1;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(255, 182, 193, 0.4);
        }

        th {
            background-color: #ffc0cb;
            color: #b4005a;
        }

        td {
            background-color: #fffafc;
        }

        .btn-sm {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4 titulo">🎀 Lista de Profesiones Registradas 🎀</h2>

        <?php if (empty($profesiones)): ?>
            <div class="alert alert-warning text-center">
                No hay profesiones registradas aún.
            </div>
        <?php else: ?>
            <div class="table-responsive table-custom p-3 rounded">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Salario (USD)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($profesiones as $profesion): ?>
                            <tr>
                                <td><?= htmlspecialchars($profesion['nombre']) ?></td>
                                <td><?= htmlspecialchars($profesion['categoria']) ?></td>
                                <td>$<?= number_format($profesion['salario'], 2) ?></td>
                                <td>
                                    <a href="editar_profesion.php?id=<?= $profesion['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="eliminar_profesion.php?id=<?= $profesion['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta profesión?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="profesiones.php" class="btn btn-custom">✨ Registrar profesión ✨</a>
        </div>
    </div>
</body>
</html>

<?php
include('../libreria/plantilla.php');
plantilla::aplicar();
$archivoPersonajes = 'personajes.json';
$archivoProfesiones = '../profesiones/profesiones.json';

$personajes = file_exists($archivoPersonajes)
    ? json_decode(file_get_contents($archivoPersonajes), true)
    : [];

$profesiones = file_exists($archivoProfesiones)
    ? json_decode(file_get_contents($archivoProfesiones), true)
    : [];

// Para mapear el ID de la profesión con su nombre y categoría
$mapaProfesiones = [];
foreach ($profesiones as $profesion) {
    $mapaProfesiones[$profesion['id']] = $profesion;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Personajes</title>

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

        img.foto-personaje {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ffb6c1;
        }

        ul.lista-profesiones {
            padding-left: 1.2rem;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4 titulo">🎀 Lista de Personajes Registrados 🎀</h2>

    <?php if (empty($personajes)): ?>
        <div class="alert alert-warning text-center">No hay personajes registrados todavía.</div>
    <?php else: ?>
        <div class="table-responsive table-custom p-3">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Profesiones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personajes as $personaje): ?>
                        <tr>
                            <td><?= htmlspecialchars($personaje['id']) ?></td> 
                            <td class="text-center">
                                <img src="<?= htmlspecialchars($personaje['foto']) ?>" alt="Foto" class="foto-personaje">
                            </td>
                            <td><?= htmlspecialchars($personaje['nombre'] . ' ' . $personaje['apellido']) ?></td>
                            <td><?= htmlspecialchars($personaje['fecha_nacimiento']) ?></td>
                            <td>
                                <ul class="lista-profesiones">
                                    <?php foreach ($personaje['profesiones'] as $profesion): ?>
                                        <?php
                                            $info = $mapaProfesiones[$profesion['id']] ?? ['nombre' => 'Desconocida', 'categoria' => 'N/A'];
                                        ?>
                                        <li>
                                            <?= htmlspecialchars($info['nombre']) ?> (<?= htmlspecialchars($info['categoria']) ?>) - <strong><?= htmlspecialchars($profesion['nivel']) ?></strong>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td class="text-center">
                                <a href="editar_personaje.php?id=<?= urlencode($personaje['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="eliminar_personaje.php?id=<?= urlencode($personaje['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este personaje?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="personajes.php" class="btn btn-custom">✨ Registrar Personaje ✨</a>
    </div>
</div>
</body>
</html>

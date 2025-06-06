<?php
include('../libreria/plantilla.php');
$archivoPersonajes = 'personajes.json';

$personajes = file_exists($archivoPersonajes)
? json_decode(file_get_contents($archivoPersonajes), true)
: [];

$archivoProfesiones = '../profesiones/profesiones.json';

$profesiones = file_exists($archivoProfesiones)
    ? json_decode(file_get_contents($archivoProfesiones), true)
    : [];

$nivelesDisponibles = ['Principiante', 'Intermedio', 'Avanzado'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? uniqid();
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $foto = trim($_POST['foto']);
    $profesionesSeleccionadas = $_POST['profesiones'] ?? [];
    $niveles = $_POST['niveles'] ?? [];

    if ($nombre && $apellido && $fechaNacimiento && $foto && !empty($profesionesSeleccionadas)) {
        $personaje = [
            'id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'fecha_nacimiento' => $fechaNacimiento,
            'foto' => $foto,
            'profesiones' => []
        ];

        foreach ($profesionesSeleccionadas as $pid) {
            $nivel = $niveles[$pid] ?? 'Principiante';
            $personaje['profesiones'][] = [
                'id' => $pid,
                'nivel' => $nivel
            ];
        }

        $personajes[] = $personaje;
        file_put_contents($archivoPersonajes, json_encode($personajes, JSON_PRETTY_PRINT));

        header('Location: personajes.php?exito=1');
        exit;
    } else {
        $error = "Todos los campos son obligatorios, y debes incluir al menos una profesión y una URL de imagen.";
    }
}
plantilla::aplicar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Personajes</title>

    <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /*Titulo*/
        h2.titulo {
            font-family: 'Pattaya', sans-serif;
            color: #ff69b4;
            font-size: 2.8rem;
            text-shadow: 2px 2px #ffc0cb;
        }
        /*Fondo*/
        body {
            background-color: rgb(248, 234, 239);
            background-image: radial-gradient(circle, rgb(239, 201, 219) 1.5px, transparent 1.5px);
            background-size: 30px 30px;
        }
        /*Formulario*/
        .formulario {
            background-color: #fff0f5;
            border: 2px solid #ffb6c1;
            border-radius: 15px; 
            box-shadow: 0 8px 16px rgba(255, 182, 193, 0.4);
            backdrop-filter: blur(3px);
        }

        .form-label {
            color:rgb(188, 33, 95);
        }

        .form-control,
        .form-select {
            border: 2px solid rgb(222, 92, 152);
        }

        h2 {
            color: #d63384;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ff69b4;
            box-shadow: 0 0 5px #ffb6c1;
        }

        /*Botones*/
        .btn-custom {
            background-color: rgb(218, 64, 141);
            border: none;
            color: white;
        }

        .btn-custom:hover {
            background-color: #ff85c1;
            color: rgb(233, 195, 214);
        }
         /*Alertas*/
        .alert-success {
            background-color: #ffccdf;
            border-color: #ffa3c1;
            color: #b4005a;
        }

        .alert-danger {
            background-color: #ffe6eb;
            border-color: #ff99aa;
            color: #d63384;
        }

        .shadow-sm {
            box-shadow: 0 4px 8px rgba(255, 105, 180, 0.3);
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4 titulo"> 🎀 Registrar Personajes 🎀</h2>

        <?php if (isset($_GET['exito'])): ?>
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                <span>✨ Personaje guardado correctamente.</span>
                <a href="../index.php" class="btn btn-sm btn-custom">Volver al Inicio</a>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="formulario p-4 rounder shadow-sm">
            <div class="mb-3">
                <label for="id" class="form-label">Identificación</label>
                <input type="text" name="id" id="id" class="form-control" value="<?= uniqid() ?>" readonly>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto (URL)</label>
                <input type="url" name="foto" id="foto" class="form-control" required oninput="mostrarFoto(this.value)">
            </div>

            <div class="mb-3">
                <label class="form-label">Profesiones</label>
                <?php foreach ($profesiones as $profesion): ?>
                    <?php
                        $profId = $profesion['id'];
                        $checked = (isset($_POST['profesiones']) && in_array($profId, $_POST['profesiones'])) ? 'checked' : '';

                        $nivelSeleccionado = $_POST['niveles'][$profId] ?? '';
                    ?>
                    <div class="form-check mb-2">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="profesiones[]"
                            value="<?= htmlspecialchars($profId) ?>"
                            id="prof_<?= htmlspecialchars($profId) ?>"
                            onchange="toggleNivel(this)"
                            <?= $checked ?>
                        
                        >
                        <label class="form-check-label" for="prof_<?= htmlspecialchars($profId) ?>">
                            <?= htmlspecialchars($profesion['nombre']) ?> (<?= htmlspecialchars($profesion['categoria']) ?>)
                        </label>

                        <select
                            name="niveles[<?= htmlspecialchars($profId) ?>]"
                            class="form-select mt-2 ms-4 nivel-select <?= $checked ? '' : 'd-none' ?>"
                        >

                            <?php foreach ($nivelesDisponibles as $nivel): ?>
                                <option value="<?= $nivel ?>" <?=$nivelSeleccionado === $nivel ? 'selected' : '' ?>><?= $nivel ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-2">
                <button type="submit" class="btn btn-custom">✨ Guardar Personaje ✨</button>
            </div>
        </form>
        
    </div>
<script>
    /*Un poco de java para que se oculta el list si no hemos checked la profesion*/
function toggleNivel(checkbox) {
    const select = checkbox.closest('.form-check').querySelector('.nivel-select');
    if (checkbox.checked) {
        select.classList.remove('d-none');
    } else {
        select.classList.add('d-none');
    }
}
</script>
</body>
</html>
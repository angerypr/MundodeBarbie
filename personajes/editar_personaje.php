<?php
include('../libreria/plantilla.php');
$archivoPersonajes = 'personajes.json';
$archivoProfesiones = '../profesiones/profesiones.json';

$personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];
$profesiones = file_exists($archivoProfesiones) ? json_decode(file_get_contents($archivoProfesiones), true) : [];

$id = $_GET['id'] ?? null;
$personaje = null;

foreach ($personajes as $p) {
    if ($p['id'] === $id) {
        $personaje = $p;
        break;
    }
}

if (!$personaje) {
    echo "Personaje no encontrado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $foto = trim($_POST['foto']);
    $profesionesSeleccionadas = $_POST['profesiones'] ?? [];

    $nuevasProfesiones = [];
    foreach ($profesionesSeleccionadas as $item) {
        $partes = explode('|', $item); // Formato esperado: id|nivel
        if (count($partes) === 2) {
            $nuevasProfesiones[] = [
                'id' => $partes[0],
                'nivel' => $partes[1]
            ];
        }
    }

    if ($nombre && $apellido && $fecha_nacimiento && $foto && !empty($nuevasProfesiones)) {
        foreach ($personajes as &$p) {
            if ($p['id'] === $id) {
                $p['nombre'] = $nombre;
                $p['apellido'] = $apellido;
                $p['fecha_nacimiento'] = $fecha_nacimiento;
                $p['foto'] = $foto;
                $p['profesiones'] = $nuevasProfesiones;
                break;
            }
        }

        file_put_contents($archivoPersonajes, json_encode($personajes, JSON_PRETTY_PRINT));
        header('Location: ver_personajes.php?editado=1');
        exit;
    } else {
        $error = "Todos los campos son obligatorios y debe seleccionarse al menos una profesión con nivel.";
    }
}
plantilla::aplicar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Personaje</title>
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
        .formulario {
            background-color: #fff0f5;
            border: 2px solid #ffb6c1;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(255, 182, 193, 0.4);
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
        .form-label {
            color: rgb(188, 33, 95);
        }
        .form-control,
        .form-select {
            border: 2px solid rgb(222, 92, 152);
        }
        .alert-danger {
            background-color: #ffe6eb;
            border-color: #ff99aa;
            color: #d63384;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4 titulo">🎀 Editar Personaje 🎀</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="formulario p-4 rounded">
        <div class="mb-3">
            <label class="form-label">ID (no editable)</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($personaje['id']) ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required value="<?= htmlspecialchars($personaje['nombre']) ?>">
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" required value="<?= htmlspecialchars($personaje['apellido']) ?>">
        </div>

        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required value="<?= htmlspecialchars($personaje['fecha_nacimiento']) ?>">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">URL de Foto</label>
            <input type="url" name="foto" id="foto" class="form-control" required value="<?= htmlspecialchars($personaje['foto']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Profesiones</label>
            <?php foreach ($profesiones as $prof): 
                $nivelActual = null;
                foreach ($personaje['profesiones'] as $pp) {
                    if ($pp['id'] === $prof['id']) {
                        $nivelActual = $pp['nivel'];
                        break;
                    }
                }
                ?>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="profesiones[]" id="profesion_<?= $prof['id'] ?>_noval" value="<?= $prof['id'] ?>|<?= $nivelActual ?? 'Principiante' ?>" <?= $nivelActual ? 'checked' : '' ?>>
                    <label class="form-check-label" for="profesion_<?= $prof['id'] ?>_noval">
                        <?= htmlspecialchars($prof['nombre']) ?> (<?= htmlspecialchars($prof['categoria']) ?>)
                    </label>
                    <select onchange="document.getElementById('profesion_<?= $prof['id'] ?>_noval').value='<?= $prof['id'] ?>|' + this.value" class="form-select mt-1">
                        <?php
                        $niveles = ['Principiante', 'Intermedio', 'Avanzado', 'Experto'];
                        foreach ($niveles as $nivel) {
                            $selected = $nivel === $nivelActual ? 'selected' : '';
                            echo "<option value=\"$nivel\" $selected>$nivel</option>";
                        }
                        ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-2">
            <button type="submit" class="btn btn-custom">💾 Guardar Cambios</button>
        </div>

        <div class="text-center mt-2">
            <a href="ver_personajes.php" class="btn btn-custom">✨ Cancelar ✨</a>
        </div>
    </form>
</div>
</body>
</html>

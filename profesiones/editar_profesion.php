<?php
include('../libreria/plantilla.php');
$archivoProfesiones = 'profesiones.json';
$profesiones = file_exists($archivoProfesiones) ? json_decode(file_get_contents($archivoProfesiones), true) : [];

$id = $_GET['id'] ?? null;
$profesion = null;

foreach ($profesiones as $p) {
    if ($p['id'] === $id) {
        $profesion = $p;
        break;
    }
}

if (!$profesion) {
    echo "Profesión no encontrada.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $categoria = trim($_POST['categoria']);
    $salario = floatval($_POST['salario']);

    if ($nombre && $categoria && $salario > 0) {
        foreach ($profesiones as &$p) {
            if ($p['id'] === $id) {
                $p['nombre'] = $nombre;
                $p['categoria'] = $categoria;
                $p['salario'] = $salario;
                break;
            }
        }

        file_put_contents($archivoProfesiones, json_encode($profesiones, JSON_PRETTY_PRINT));
        header('Location: ver_profesiones.php?editado=1');
        exit;
    } else {
        $error = "Todos los campos son obligatorios y el salario debe ser mayor a 0.";
    }
}
plantilla::aplicar()
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Profesión</title>
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
        <h2 class="text-center mb-4 titulo">🎀 Editar Profesión 🎀</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="formulario p-4 rounded">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la profesión</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required value="<?= htmlspecialchars($profesion['nombre']) ?>">
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" id="categoria" class="form-select" required>
                <option value="">Selecciona una categoría</option>
                <?php
                $categorias = ["Ciencia", "Arte", "Deporte", "Entretenimiento", "Educación", "Salud", "Tecnología", "Negocios"];
                foreach ($categorias as $cat) {
                    $selected = $profesion['categoria'] === $cat ? 'selected' : '';
                    echo "<option value=\"$cat\" $selected>$cat</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="salario" class="form-label">Salario mensual estimado (USD$)</label>
            <input type="number" name="salario" id="salario" class="form-control" min="1" step="0.01" required value="<?= $profesion['salario'] ?>">
        </div>

        <div class="text-center mt-2">
            <button type="submit" class="btn btn-custom">💾 Guardar Cambios</button>
        </div>

        <div class="text-center mt-2">
            <a href="ver_profesiones.php" class="btn btn-custom">✨ Cancelar ✨</a>
        </div>
    </form>
</div>
</body>
</html>
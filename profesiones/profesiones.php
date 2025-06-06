<?php
include('../libreria/plantilla.php');
plantilla::aplicar();
$archivoProfesiones = 'profesiones.json';

$profesiones = file_exists($archivoProfesiones)
? json_decode(file_get_contents($archivoProfesiones), true)
: [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $categoria = trim($_POST['categoria']);
    $salario = floatval($_POST['salario']);

    if ($nombre && $categoria && $salario > 0) {
        $profesion = [
            'id' => uniqid(),
            'nombre' => $nombre,
            'categoria' => $categoria,
            'salario' => $salario
        ];

        $profesiones[] = $profesion;
        file_put_contents($archivoProfesiones, json_encode($profesiones, JSON_PRETTY_PRINT));

        header('Location: profesiones.php?exito=1');
        exit;
    } else {
        $error = "Todos los campos son obligatorios y el salario debe ser mayor a 0.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Profesiones</title>

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
            background-color:rgb(248, 234, 239);
            background-image: radial-gradient(circle,rgb(239, 201, 219) 1.5px, transparent 1.5px);
            background-size: 30px 30px;
        }
        .formulario {
            background-color: #fff0f5;
            border: 2px solid #ffb6c1;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(255, 182, 193, 0.4);
            backdrop-filter: blur(3px);
        }
        h2 {
            color: #d63384;
        }
        /*Botones*/
        .btn-custom {
            background-color:rgb(218, 64, 141);
            border: none;
            color: white;
        }

        .btn-custom:hover {
            background-color:  #ff85c1;
            color:rgb(233, 195, 214);
        }

        .form-label {
            color:rgb(188, 33, 95);
        }

        .form-control,
        .form-select {
            border: 2px solid rgb(222, 92, 152);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ff69b4;
            box-shadow: 0 0 5px #ffb6c1;
        }

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
        <h2 class="text-center mb-4 titulo"> 🎀 Registrar Profesiones 🎀</h2>

        <?php if (isset($_GET['exito'])): ?>
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                <span>✨ Profesión guardada correctamente.</span>
                <a href="../index.php" class="btn btn-sm btn-custom">Volver al Inicio</a>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="formulario p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la profesión</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Ej. Diseñadora, Cantante...">
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select name="categoria" id="categoria" class="form-select" required>
                    <option value="">Selecciona una categoría</option>
                    <option value="Ciencia">Ciencia</option>
                    <option value="Arte">Arte</option>
                    <option value="Deporte">Deporte</option>
                    <option value="Entretenimiento">Entretenimiento</option>
                    <option value="Educación">Educación</option>
                    <option value="Salud">Salud</option>
                    <option value="Tecnología">Tecnología</option>
                    <option value="Negocios">Negocios</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="salario" class="form-label">Salario mensual estimado (USD$)</label>
                <input type="number" name="salario" id="salario" class="form-control" min="1" step="0.01" required>
            </div>

            <div class="text-center mt-2">
            <button type="submit" class="btn btn-custom">✨ Guardar Profesión ✨</button>
            </div>
        </form>
    </div>
</body>
</html>
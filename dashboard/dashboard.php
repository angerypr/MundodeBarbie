<?php
include('../libreria/plantilla.php');
plantilla::aplicar();

$personajes = file_exists('../personajes/personajes.json') ? json_decode(file_get_contents('../personajes/personajes.json'), true) : [];
$profesiones = file_exists('../profesiones/profesiones.json') ? json_decode(file_get_contents('../profesiones/profesiones.json'), true) : [];

date_default_timezone_set('America/Santo_Domingo');

$mapaProfesiones = [];
foreach ($profesiones as $profesion) {
    $mapaProfesiones[$profesion['id']] = $profesion;
}

//Para el total de personajes y profesiones
$totalPersonajes = count($personajes);
$totalProfesiones = count($profesiones);

//Para la edad promedio
$hoy = new DateTime();
$edades = [];
foreach ($personajes as $p) {
    $nacimiento = new DateTime($p['fecha_nacimiento']);
    $edades[] = $nacimiento->diff($hoy)->y;
}
$edadPromedio = $edades ? round(array_sum($edades) / count($edades), 1) : 0;

//Datos por categoria
$categorias = [];
$niveles = [];
$salariosPorCategoria = [];
$salariosPorPersonaje = [];

foreach ($personajes as $p) {
    foreach ($p['profesiones'] as $prof) {
        $profInfo = $mapaProfesiones[$prof['id']] ?? null;
        if ($profInfo) {
            // Categorías
            $cat = $profInfo['categoria'];
            $categorias[$cat] = ($categorias[$cat] ?? 0) + 1;

            // Niveles
            $niv = $prof['nivel'];
            $niveles[$niv] = ($niveles[$niv] ?? 0) + 1;

            // Salario por categoría
            $salariosPorCategoria[$cat][] = $profInfo['salario'];

            // Salario total por personaje
            $salariosPorPersonaje[$p['nombre'] . ' ' . $p['apellido']] = 
                ($salariosPorPersonaje[$p['nombre'] . ' ' . $p['apellido']] ?? 0) + $profInfo['salario'];
        }
    }
}

//Nivel mas comun
$nivelMasComun = !empty($niveles) ? array_search(max($niveles), $niveles) : 'N/A';

//Profesion con salario mas alto y mas bajo
usort($profesiones, fn($a, $b) => $b['salario'] <=> $a['salario']);
$profesionMasAlta = $profesiones[0]['nombre'] ?? 'N/A';
$profesionMasBaja = end($profesiones)['nombre'] ?? 'N/A';

//Salario promedio
$todosSalarios = array_column($profesiones, 'salario');
$salarioPromedio = count($todosSalarios) ? round(array_sum($todosSalarios) / count($todosSalarios), 2) : 0;

//Personaje con salario mas alto
arsort($salariosPorPersonaje);
$personajeTop = array_key_first($salariosPorPersonaje);
?>

<!DOCTYPE  html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Barbie</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /*Subtitulos*/
        h1 {
            font-family: 'Pattaya', sans-serif;
            color: #ff69b4;
            text-shadow: 2px 2px #ffc0cb;
        }

        /*Tarjetas*/
        .card {
            background: linear-gradient(135deg, #fff0f5,rgb(247, 216, 231));
            border: none;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 8px 20px rgba(255, 182, 193, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #d63384;
            margin-bottom: 0.5rem;
        }

        .card p {
           font-size: 1.1rem;
           color: #650033;
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

        /*Grafico*/
        .grafico {
            max-width: 300px;
            max-height: 300px;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4 titulo">🎀 Dashboard Mundo de Barbie 🎀</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
            <div class="col"><div class="card p-3"><h5 class="card-title">Total Personajes</h5><p><?= $totalPersonajes ?></p></div></div>
            <div class="col"><div class="card p-3"><h5 class="card-title">Total Profesiones</h5><p><?= $totalProfesiones ?></p></div></div>
            <div class="col"><div class="card p-3"><h5 class="card-title">Edad Promedio</h5><p><?= $edadPromedio ?> años</p></div></div>
            <div class="col"><div class="card p-3"><h5 class="card-title">Nivel más común</h5><p><?= $nivelMasComun ?></p></div></div>
            <div class="col"><div class="card p-3"><h5 class="card-title">Salario Promedio</h5><p>$<?= $salarioPromedio ?></p></div></div>
            <div class="col"><div class="card p-3"><h5 class="card-title">Personaje Con el Salario Más Alto</h5><p><?= $personajeTop ?></p></div></div>
            <div class="col"><div class="card p-3"><h5 class="card-title">Profesión Con el Salario Más Alto</h5><p><?= $profesionMasAlta ?></p></div></div>
            <div class="col"><div class="card p-3"><h5 class="card-title">Profesión Con el Salario Más Bajo</h5><p><?= $profesionMasBaja ?></p></div></div>
        </div>
    
    <div class="mt-5">
        <h1 class="text-center">🎀 Personajes por categoría de profesión 🎀</h3>
        <canvas id="graficoPersonajesCategoria" class="grafico"></canvas>
    </div>
    <div class="mt-5">
        <h1 class="text-center ">🎀 Salarios por categoría 🎀</h3>
        <canvas id="graficoCategorias" height="120"></canvas>
    </div>
    </div>
    <script>
    const ctx = document.getElementById('graficoCategorias').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($salariosPorCategoria)) ?>,
            datasets: [{
                label: 'Salario Promedio (USD$)',
                data: <?= json_encode(array_map(fn($arr) => round(array_sum($arr)/count($arr), 2), $salariosPorCategoria)) ?>,
                backgroundColor: 'rgba(255, 105, 180, 0.5)',
                borderColor: '#ff69b4',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#d63384'
                    }
                },
                x: {
                    ticks: {
                        color: '#d63384'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#d63384'
                    }
                }
            }
        }
    });

    const ctx2 = document.getElementById('graficoPersonajesCategoria').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_keys($categorias)) ?>,
            datasets: [{
                label: 'Cantidad de personajes',
                data: <?= json_encode(array_values($categorias)) ?>,
                backgroundColor: [
                    '#ffc0cb', '#ff69b4', '#ffb6c1', '#e75480', '#db7093',
                    '#c71585', '#ff1493', '#ff69b4', '#d8bfd8', '#dda0dd'
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        color: '#d63384'
                    }
                }
            }
        }
    });
</script>
<div class="text-center mt-3">
            <a href="../index.php" class="btn btn-custom">✨ Volver al Inicio ✨</a>
        </div>
</body>
</html>
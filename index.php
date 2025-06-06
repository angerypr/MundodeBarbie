<?php
include('libreria/plantilla.php');
plantilla::aplicar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title> Mundo Barbie - Inicio </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka&family=Poppins&display=swap" rel="stylesheet">


    <style>
        /*Fondo*/
        body{
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url('https://media.houseandgarden.co.uk/photos/647f0066726bb931873b5523/16:9/w_4335,h_2438,c_limit/AD0623_BARBIE_2%20copy.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 228, 242, 0.7), rgba(255, 192, 203, 0.7), rgba(255, 209, 220, 0.7));
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            z-index: 0;
        }

        @keyframes gradientMove {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }

    .container-barbie {
        position: relative;
        z-index: 1;
        background-color: white;
        border-radius: 25px;
        padding: 40px 30px;
        box-shadow: 0 10px 30px rgba(255, 105, 180, 0.4);
        max-width: 1000px;
        width: 100%;
        margin: 50px auto;
        animation: fadeIn 1.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to{
            opacity: 1;
            transform: translateY(0);
        }
    }

    /*Titulo + subrayado*/
    .barbie-title {
        font-family: 'Pattaya', sans-serif;
        color: #ff69b4;
        font-size: 2.8rem;
        text-shadow: 2px 2px #ffc0cb;
        animation: subtleBlink 4s linear infinite;
    }

    @keyframes subtleBlink {
        0%,
        100% {
            opacity: 1;
            text-shadow: 2px 2px #ffc0cb;
        }
        50% {
            opacity: 0.85;
            text-shadow: 2px 2px #ff9aca;
        }
    }
     
    /*Tarjetas*/
    .barbie-card {
        border: none;
        border-radius: 20px;
        background: linear-gradient(145deg, #fff0f5, #ffe6f0);
        box-shadow: 0 8px 15px rgba(255, 105, 180, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: glowPulse 3s infinite alternate, floatUpDown 6s ease-in-out infinite;
        cursor: pointer;
    }

    @keyframes glowPulse {
        0% {
            box-shadow: 0 0 10px rgba(255, 105, 180, 0.3);
        }
        100% {
            box-shadow: 0 0 25px rgba(255, 105, 180, 0.5);
        }
    }

    @keyframes floatUpDown {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(0);
        }
    }

    .barbie-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 0 30px #ff69b4;
        color: white;
    }

    .barbie-card i.bi {
        font-size: 2.4rem;
        margin-bottom: 8px;
        color: #ff69b4;
        animation: bounceIcon 3s infinite;
    }

    @keyframes bounceIcon {
        0%,
        100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-12px);
        }
    }

    .barbie-card h5 {
        font-family: 'Fredoka', sans-serif;
        font-size: 1.2rem;
        color: #d63384;
        margin-bottom: 15px;
    }

    .barbie-btn {
        background: linear-gradient(to right, #ff69b4, #ff1493);
        border: none;
        color: white;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
        z-index: 0;
    }

    .barbie-btn::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.6) 0%, transparent 80%);
        transform: translateX(-100%) translateY(0) rotate(25deg);
        transition: transform 0.5s ease;
        z-index: -1;
        border-radius: 30px;
    }

    .barbie-btn:hover::before {
        transform: translateX(100%) translateY(0) rotate(25deg);
    }

    .barbie-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px #ff69b4;
    }

    .bi {
      font-size: 1.5rem;
      margin-bottom: 8px;
      color: #ff69b4;
    }
    </style>
</head>
<body>
<div class="container container-barbie text-center">
<h1 class="barbie-title mb-4">✨Sistema de Gestión del Mundo de Barbie✨</h1>

<div class="row g-4 justify-content-center">
    <div class="col-sm-6 col-lg-4">
        <div class="card barbie-card p-4" tabindex="0">
            <i class="bi bi-briefcase-fill"></i>
            <h5>Registrar Profesión</h5>
            <a href="../profesiones/profesiones.php" class="btn barbie-btn mt-2">Ir</a>
</div>
</div>
            <div class="col-sm-6 col-lg-4">
        <div class="card barbie-card p-4" tabindex="0">
            <i class="bi bi-person-plus-fill"></i>
            <h5>Registrar Personaje</h5>
            <a href="personajes/personajes.php" class="btn barbie-btn mt-2">Ir</a>
</div>
</div>
<div class="col-sm-6 col-lg-4">
        <div class="card barbie-card p-4" tabindex="0">
            <i class="bi bi-gear-fill"></i>
            <h5>Lista de Profesiones</h5>
            <a href="profesiones/ver_profesiones.php" class="btn barbie-btn mt-2">Ir</a>
</div>
</div>
<div class="col-sm-6 col-lg-4">
        <div class="card barbie-card p-4" tabindex="0">
            <i class="bi bi-gear-fill"></i>
            <h5>Lista de Personajes</h5>
            <a href="personajes/ver_personajes.php" class="btn barbie-btn mt-2">Ir</a>
</div>
</div>
<div class="col-sm-6 col-lg-4">
        <div class="card barbie-card p-4" tabindex="0">
            <i class="bi bi-bar-chart-fill"></i>
            <h5>Panel de Estadísticas</h5>
            <a href="dashboard/dashboard.php" class="btn barbie-btn mt-2">Ir</a>
</div>
</div>
</body>
</html>
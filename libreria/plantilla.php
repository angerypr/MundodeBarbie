<?php
class plantilla {
    public static $instancia = null;

    public static function aplicar(): plantilla {
        if (self::$instancia == null) {
            self::$instancia = new plantilla();
        }
        return self::$instancia;
    }

    public function __construct() {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>🎀 Mundo de Barbie 🎀</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                /*Color de la barra*/
                .navbar-barbie {
                    background-color: rgba(220, 8, 118, 0.57) !important;
                }
                /*Color de las letras de las funcionalidades*/
                .navbar-barbie .navbar-nav .nav-link,
                /*Color mundo de barbie*/
                .navbar-barbie .navbar-brand {
                    color: white !important;
                }
            </style>
        </head>
        <body>

        <nav class="navbar navbar-expand-lg navbar-dark navbar-barbie">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/index/index.php">
                    <span>🎀 Mundo de Barbie 🎀</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="../index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="../profesiones/profesiones.php">Agregar profesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="../personajes/personajes.php">Agregar Personaje</a></li>
                        <li class="nav-item"><a class="nav-link" href="../profesiones/ver_profesiones.php">Ver Profesiones</a></li>
                        <li class="nav-item"><a class="nav-link" href="../personajes/ver_personajes.php">Ver Personajes</a></li>
                        <li class="nav-item"><a class="nav-link" href="../../dashboard/dashboard.php">Estadísticas</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
    }

    public function __destruct() {
        ?>
            <footer class="text-center mt-5 mb-3">
                <hr>
                <p class="text-muted">
                    &copy; <?= date('Y') ?> - Todos los derechos reservados | Mundo de Barbie
                </p>
            </footer>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
}
?>

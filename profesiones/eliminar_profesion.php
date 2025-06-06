<?php
$archivoProfesiones = 'profesiones.json';
$profesiones = file_exists($archivoProfesiones) ? json_decode(file_get_contents($archivoProfesiones), true) : [];

$id = $_GET['id'] ?? null;
$nuevaLista = [];

$eliminado = false;
foreach ($profesiones as $p) {
    if ($p['id'] !== $id) {
        $nuevaLista[] = $p;
    } else {
        $eliminado = true;
    }
}

if ($eliminado) {
    file_put_contents($archivoProfesiones, json_encode($nuevaLista, JSON_PRETTY_PRINT));
    header('Location: ver_profesiones.php?eliminado=1');
    exit;
} else {
    echo "Profesión no encontrada.";
    exit;
}
?>

<?php
$archivoPersonajes = 'personajes.json';

if (!isset($_GET['id'])) {
    echo "ID no proporcionado.";
    exit;
}

$id = $_GET['id'];

$personajes = file_exists($archivoPersonajes)
    ? json_decode(file_get_contents($archivoPersonajes), true)
    : [];

$personajes = array_filter($personajes, function($p) use ($id) {
    return $p['id'] != $id;
});

file_put_contents($archivoPersonajes, json_encode(array_values($personajes), JSON_PRETTY_PRINT));

header('Location: ver_personajes.php');
exit;

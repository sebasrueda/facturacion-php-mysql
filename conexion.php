<!-- Realizar la conexión entre PHP y MySQL -->
<?php
// Código para conectar desde mi casa
/* $host = '127.0.0.1:33065';
$user = 'root';
$password = '1234';
$db = 'facturacion'; */

// Código para conectar desde el CEFIT
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'facturacion';

$connection = @mysqli_connect($host, $user, $password, $db);

if (!$connection) {
    echo "Error en la conexión con MySQL.";
}

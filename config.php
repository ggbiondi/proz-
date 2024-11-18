<?php
// config.php
$host = 'localhost';
$db   = 'proz_visitas';
$user = 'root'; // Insira seu usuário
$pass = '';     // Insira sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
?>

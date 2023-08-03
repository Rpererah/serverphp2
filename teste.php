<?php
$host = 'localhost';
$port = '8889';
$name = 'teste';
$user = 'root';
$password = 'root';

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$name};";
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Conexão estabelecida com sucesso!';
} catch (PDOException $e) {
    echo 'Erro na conexão: ' . $e->getMessage();
}
?>

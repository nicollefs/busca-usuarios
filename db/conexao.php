<?php
$servidor="localhost";
$usuario="root";
$senha="";
$banco="banco_usuarios";

$pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);

?>
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestao_clientes');
define('DB_PORT', '3306');
define('DB_USER', 'root');
define('DB_PASS', 'root');


$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

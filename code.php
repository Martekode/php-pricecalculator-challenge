<?php
declare(strict_types=1);
require_once ('vendor/autoload.php');
$username = getenv('USER_NAME');
$password = getenv('USER_PASSWORD');
$servername = getenv('SERVER_NAME');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,1),"./php-pricecalculator-challenge/.env");
$dotenv->load();

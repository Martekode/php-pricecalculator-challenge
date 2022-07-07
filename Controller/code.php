<?php
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,1),".env");
$dotenv->load();

$dbname = $_ENV['DB_NAME'];
$username = $_ENV['USER_NAME'];
$password = $_ENV['USER_PASSWORD'];
$servername = getenv('SERVER_NAME');

try {
  $conn = new PDO("mysql:dbname=$dbname;host=$servername", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$sqlResult = $conn->query("select name,price from product");
   print_r($sqlResult);
   while ($row = $sqlResult->fetch()) {
       print "<p>Name: {$row[0]} {$row[1]}</p>";
   }
?> 
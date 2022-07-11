<?php

declare(strict_types=1);
class DBLoader
{
  private string $dbname;
  private string $username;
  private string $password;
  private string $servername;
  private PDO $conn;

  public function __construct()
  {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1), ".env");
    $dotenv->load();
    $this->dbname = $_ENV['DB_NAME'];
    $this->username = $_ENV['USER_NAME'];
    $this->password = $_ENV['USER_PASSWORD'];
    $this->servername = getenv('SERVER_NAME');
    $this->makeConnection();
  }
  private function makeConnection()
  {
    try {
      $this->conn = new PDO("mysql:dbname=" . $this->dbname . ";host=" . $this->servername, $this->username, $this->password);
      echo "Connected successfully";
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
  public function getConn()
  {
    return $this->conn;
  }
  public function productFetch($POST)
  {
    $a = $this->getConn()->query("select price, name from product where id =" . $POST['products']);
    $b = $a->fetch();
    return $b;
  }
  public function customerFetch($POST)
  {
    $a = $this->getConn()->query("select group_id,fixed_discount,variable_discount from customer where id =" . $POST['customers']);
    $b = $a->fetch();
    return $b;
  }
  public function groupDiscountFetch($customerDetails)
  {
    $a =  $this->getConn()->query("select fixed_discount,variable_discount from customer_group where id =" . $customerDetails['group_id']);
    $b = $a->fetch();
    return $b;
  }
}

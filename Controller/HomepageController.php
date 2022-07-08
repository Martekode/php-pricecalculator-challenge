<?php
declare(strict_types = 1);
require 'Model/DBLoader.php';

class HomepageController
{
    private DBLoader $dbLoader;



    public function __construct(){
      $this->dbLoader = new DBLoader();
    }

    //render function with both $_GET and $_POST vars available if it would be needed.
    public function render(array $GET, array $POST)
    {
        //this is just example code, you can remove the line below
        $user = new User('John Smith');
        $sqlResult = $this->dbLoader->getConn()->query("select name,price from product");

        // you should not echo anything inside your controller - only assign vars here
        
        // Models will be responsible for getting the data, for example if you want to get some students from a database:
        // $students = StudentHelper::getAllStudents();
        // The line above this one will use a StudentHelper model that you can make and require in this file
        // the getAllStudents is a static method, which means you can call this function without an instance of your StudentHelper
        // If you want to learn more about static methods -> https://www.w3schools.com/Php/php_oop_static_methods.asp
        
        // then the view will actually display them.

        //load the view
        require 'View/homepage.php';
    }
}

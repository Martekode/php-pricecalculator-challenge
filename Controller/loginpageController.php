<?php

declare(strict_types=1);

class loginpageController
{
    private DBLoader $dbloader;
    public function __construct()
    {
        $this->dbloader = new DBLoader();
    } //render function with both $_GET and $_POST vars available if it would be needed.
    public function render(array $GET, array $POST)
    {
        $customerResult = $this->dbloader->customerResult();
        $customerArray = [];
        while ($row = $customerResult->fetch()) {
            $customerArray[$row[1] . $row[2]] = new User($row[1] . $row[2], 'default');
        }
        //you should not echo anything inside your controller - only assign vars here
        // then the view will actually display them.
        if (isset($POST['login'])) {
            var_dump($POST);
            var_dump($customerArray);
        }
        //load the view
        require 'View/loginpage.php';
    }
}

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
        $customerArray2 = [];
        while ($row = $customerResult->fetch()) {
            $customerArray2[$row[1] . $row[2]] = new User($row[1] . $row[2], 'default');
        }
        //you should not echo anything inside your controller - only assign vars here
        // then the view will actually display them.
        if (isset($POST['login'])) {
            var_dump($POST);
            var_dump($customerArray2);
            var_dump($customerArray2[$POST['usernames']]);
            if ($POST['password'] === $customerArray2[$POST['usernames']]->getPassword()) {
                $controller = new HomepageController();
                $controller->render($_GET, $_POST, $customerArray2[$POST['usernames']]);
            } else {
                echo "nono";
            }
        }
        require 'View/loginpage.php';
        //load the view

    }
}

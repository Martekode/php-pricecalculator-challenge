<?php

declare(strict_types=1);

class User
{
    private $name;
    private string $password;

    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct' . $numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }
    public function __construct1($name)
    {
        $this->name = $name;
    }
    public function __construct2($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

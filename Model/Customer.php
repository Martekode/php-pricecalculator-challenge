<?php

declare(strict_types=1);

class Customer {
    private int $id;
    private string $firstName;
    private string $lastName;

    public function __construct( string $lastName, string $firstName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }


}
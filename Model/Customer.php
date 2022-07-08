<?php

declare(strict_types=1);
class Customer
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private int $groupID;
    private int $variableDiscount;
    private int $fixedDiscount;

    public function __construct(int $id, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getGroupId(): int
    {
        return $this->groupID;
    }

    public function getVariableDiscount(): int
    {
        return $this->variableDiscount;
    }

    public function getFixedDiscount(): int
    {
        return $this->fixedDiscount;
    }
}

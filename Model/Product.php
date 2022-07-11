<?php
declare(strict_types=1);
class Product
{
    private string $name;
    private  $price;


    public function __construct( string $name,   $price)
    {

        $this->name = $name;
        $this->price = $price;

    }
    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }


}
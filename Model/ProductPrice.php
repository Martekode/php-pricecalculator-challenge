<?php
declare(strict_types=1);
class ProductPrice {
    private array $productDetails;


    public function __construct(array  $productDetails) {
        $this->productDetails = $productDetails;
    }

    /**
     * @return array
     */
    public function getProductDetails(): array
    {
        return $this->productDetails;
    }

}

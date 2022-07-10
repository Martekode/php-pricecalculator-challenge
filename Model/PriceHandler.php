<?php

declare(strict_types=1);
class PriceHandler
{
    private array $productDetails;
    private array $customerDetails;
    private array $groupDiscountDetails;
    private array $allDiscounts;
    private int $bestFixedDiscount;
    private float $outcome;

    public function __construct(array $productDetails, array $customerDetails, array $groupDiscountDetails)
    {
        $this->productDetails = $productDetails;
        $this->customerDetails = $customerDetails;
        $this->groupDiscountDetails = $groupDiscountDetails;
        $this->allDiscounts['fixed_discount'] = $this->customerDetails['fixed_discount'];
        $this->allDiscounts['variable_discount'] = $this->customerDetails['variable_discount'];
        $this->allDiscounts['group_fixed_discount'] = $this->groupDiscountDetails['fixed_discount'];
        $this->allDiscounts['group_variable_discount'] = $this->groupDiscountDetails['variable_discount'];
    }
    public function refactorDiscounts()
    {
        foreach ($this->allDiscounts as $type => $discount) {
            if ($discount == null) {
                $this->allDiscounts[$type] = 0;
            }
        }
    }
    public function bestFixedDiscount()
    {
        if ($this->allDiscounts['fixed_discount'] > $this->allDiscounts['group_fixed_discount']) {
            $this->bestFixedDiscount = $this->allDiscounts['fixed_discount'];
        } else {
            $this->bestFixedDiscount = $this->allDiscounts['group_fixed_discount'];
        }
    }
    public function bestVariableDiscount()
    {
        if ($this->allDiscounts['variable_discount'] > $this->allDiscounts['group_variable_discount']) {
            $this->bestVariableDiscount = $this->allDiscounts['variable_discount'];
        } else {
            $this->bestVariableDiscount = $this->allDiscounts['group_variable_discount'];
        }
    }
    public function calculatePrice()
    {
        $euroProductPrice = $this->productDetails['price'] / 100;
        $fixedDisPrice = $euroProductPrice - $this->bestFixedDiscount;
        $varDisPrice = $euroProductPrice - (($euroProductPrice / 100) * $this->bestVariableDiscount);
        if ($fixedDisPrice > $varDisPrice) {
            $this->outcome = $varDisPrice;
        } else {
            $this->outcome = $fixedDisPrice;
        }
    }
    //getters
    public function getOutcome()
    {
        return $this->outcome;
    }
    public function getProductDetails()
    {
        return $this->productDetails;
    }
}

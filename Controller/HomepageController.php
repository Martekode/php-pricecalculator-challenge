<?php

declare(strict_types=1);
require 'Model/DBLoader.php';
require 'Model/Product.php';
require 'Model/Customer.php';
require 'Model/PriceHandler.php';
class HomepageController
{
    private DBLoader $dbLoader;
    //render function with both $_GET and $_POST vars available if it would be needed.
    public function __construct()
    {
        $this->dbLoader = new DBLoader();
    }
    public function render(array $GET, array $POST)
    {
        //this is just example code, you can remove the line below
        $user = new User('John Smith');

        $productsResult = $this->dbLoader->getConn()->query("select id,name,price from product");
        $customerResult = $this->dbLoader->getConn()->query("select id,firstname,lastname from customer order by firstname");
        $productArray = [];
        while ($row = $productsResult->fetch()) {
            //  print "<p>Name: {$row[0]} {$row[1]}</p>";
            $productArray[] = new Product($row[0], $row[1], $row[2]);
        }
        $customerArray = [];
        while ($row = $customerResult->fetch()) {
            $customerArray[] = new Customer($row[0], $row[1], $row[2]);
        }
        // function bestFixedDiscount(int $discountOne, int $discountTwo)
        // {
        //     $bestDiscount = 0;
        //     if ($discountOne > $discountTwo) {
        //         $bestDiscount = $discountOne;
        //     } else {
        //         $bestDiscount = $discountTwo;
        //     }
        //     return $bestDiscount;
        // }
        // function bestVariableDiscount(int $discountOne, int $discountTwo)
        // {
        //     $bestDiscount = 0;
        //     if ($discountOne > $discountTwo) {
        //         $bestDiscount = $discountOne;
        //     } else {
        //         $bestDiscount = $discountTwo;
        //     }
        //     return $bestDiscount;
        // }
        // function calculatePrice(int $fixed, int $variable, int $productPrice)
        // {
        //     $outcomePrice = 0;
        //     $euroProductPrice = $productPrice / 100;
        //     $fixedDisPrice = $euroProductPrice - $fixed;
        //     $varDisPrice = $euroProductPrice - (($euroProductPrice / 100) * $variable);
        //     if ($fixedDisPrice > $varDisPrice) {
        //         $outcomePrice = $varDisPrice;
        //         return $outcomePrice;
        //     } else {
        //         $outcomePrice = $fixedDisPrice;
        //         return $outcomePrice;
        //     }
        // }

        if (isset($POST['submit'])) {
            var_dump($POST);
            $productDetails = $this->dbLoader->productFetch($POST);
            $customerDetails = $this->dbLoader->customerFetch($POST);
            $groupDiscountDetails = $this->dbLoader->groupDiscountFetch($customerDetails);
            $priceHandler = new PriceHandler($productDetails, $customerDetails, $groupDiscountDetails);
            $priceHandler->refactorDiscounts();
            $priceHandler->bestFixedDiscount();
            $priceHandler->bestVariableDiscount();
            $priceHandler->calculatePrice();
            $productDetails = $priceHandler->getProductDetails();
            $outcome = $priceHandler->getOutcome();
            // $productDetails = $productFetch->fetch();
            // $groupDiscountDetails = $groupDiscountFetch->fetch();
            // $allDiscounts['fixed_discount'] = $customerDetails['fixed_discount'];
            // $allDiscounts['variable_discount'] = $customerDetails['variable_discount'];
            // $allDiscounts['group_fixed_discount'] = $groupDiscountDetails['fixed_discount'];
            // $allDiscounts['group_variable_discount'] = $groupDiscountDetails['variable_discount'];
            // var_dump($productDetails);
            // var_dump($customerDetails);
            // var_dump($allDiscounts);
            // foreach ($allDiscounts as $type => $discount) {
            //     if ($discount == null) {
            //         $allDiscounts[$type] = 0;
            //     }
            // }



            // var_dump($allDiscounts);
            // $bestFixedDiscount = bestFixedDiscount($allDiscounts['fixed_discount'], $allDiscounts['group_fixed_discount']);
            // $bestVariableDiscount = bestVariableDiscount($allDiscounts['variable_discount'], $allDiscounts['group_variable_discount']);
            // var_dump($bestFixedDiscount);
            // var_dump($bestVariableDiscount);
            // $outcome = calculatePrice($bestFixedDiscount, $bestVariableDiscount, $productDetails['price']);
            // var_dump($outcome);
        }
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

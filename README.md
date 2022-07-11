# PHP-Pricecalculator-challenge

## Goal
    1. Apply basic OOP principles

    2. Import data with a database

    3. Learn to use an MVC


## The Mission

    1. Customer (Firstname, Lastname)

    2. A customer group (Name)

    3. A product (product name, price in cents)

    Notice that the price is in cents stored as an integer, not as a float. This is because you should never store currency as a float. The reason for this is that they store the number with unexpected rounding behavior. For example, it will store 5 as 4.999999999999999999 (scientific fraction), making pennies appear and disappear, once you start to do calculations with multiple floats.

----


# Model View Controller (MVC)

   - MVC is a design pattern used to decouple user-interface (view), data (model), and application logic (controller). This pattern helps to achieve separation of concerns.

    The Controller responds to user actions and invokes changes on the model or view as appropriate.

    Model/: Most of your code should be here, for example the Product and Customer class.

    View/: Your HTML files.



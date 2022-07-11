# php-pricecalculator-challenge

brian

## explenation

so where do we start. we started this excersise with our hands in our hair to make the .env and connection to the database work for both me and Alex. but let's here just explain the code.

## step one

we copied the required files from the github repo that had the boilerplate code for mvc. the main winnings of this is that we got the main structure for free from the coatches. at first it was confusing sinds we didn't know what to place where. the goal was to place as much as you can in classes wich me tried to do. This is probably not the best way or the best intended way to do this. But this is what we came up with.

## step two

first we started with the selection dropdown menus.

- ## the homepage controller

```php
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
```

this pull the info from the database and loops over the returned value, its gonna make a new object for every value from what was returned. this is pushed into an array so we can use that in the view.

- ## the view

```php
<form method="post">
    <select name="products" id="cars">

        <?php
        foreach ($productArray as $product) {
            $name = ucfirst($product->getName());
            $id = ucfirst($product->getId());
            echo "<option value='" . $id . "'>" . $name . "</option>";
        }
        ?>

    </select>
    <h2>select the customer</h2>

    <select name="customers" id="customers">

        <?php
        foreach ($customerArray as $customer) {
            $firstName = ucfirst($customer->getFirstName());
            $lastName = ucfirst($customer->getLastName());
            $id = ucfirst($customer->getId());
            echo "<option value=" . $id . ">" . $firstName . " " . $lastName . "</option>";
        }
        ?>
    </select>
    <br><button name="submit">show price</button>
    </form>
```

we made a foreach foreach of the arrays to generate an option into the dropdown.

## step 3

ofcourse we made some new objects but from what classes?

- ## Product class

```php
declare(strict_types=1);
class Product
{
    private string $name;
    private int $price;
    private int $id;

    public function __construct(int $id, string $name, int $price)
    {
        $this->id = $id;
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

    public function getId()
    {
        return $this->id;
    }
}
```

some basic values and getters.

- ## Customer class

```php
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
```

this is already a hint we didn't do everything optimally sinds there is a lot that i don't use in here. But that's good to remember for the next time.

## step 4

after that we wanted to search specifically for the values that is selected from those dropdown menus. so put everything in a form as given in the snippit above. so we also made a button and some logic for it.

---

the code below is the final cut... this has been refactored and is by all means not how we started. alot of it started as loose code. this is the refactored version.

- ## homepage controller

```php
if (isset($POST['submit'])) {
        var_dump($POST);
        $productDetails = $this->dbLoader->productFetc($POST);
        $customerDetails = $this->dbLoader->customerFetc($POST);
        $groupDiscountDetails =$this->dbLoader->groupDiscountFetch($customerDetails);
        $priceHandler = new PriceHandler($productDetails,$customerDetails, $groupDiscountDetails);
        $priceHandler->refactorDiscounts();
        $priceHandler->bestFixedDiscount();
        $priceHandler->bestVariableDiscount();
        $priceHandler->calculatePrice();
        $productDetails = $priceHandler->getProductDetails();
        $outcome = $priceHandler->getOutcome();
}
```

- ## the view

```php
<h1>
    <?php
    if (isset($POST['submit'])) {
        echo $productDetails['name'] . "<br>";
        echo "€ " . $productDetails['price'] / 100;
    }
    ?>
</h1>
```

i place the name and the price in an h1 tag. this is the price from the product. some of the logic in the button if isset will be explained when we explain the classes.

## step 5

the DBLoader class
this is the class that will make the connection with the database and fetch the data from the database.

```php
declare(strict_types=1);
class DBLoader
{
  private string $dbname;
  private string $username;
  private string $password;
  private string $servername;
  private PDO $conn;

  public function __construct()
  {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1), ".env");
    $dotenv->load();
    $this->dbname = $_ENV['DB_NAME'];
    $this->username = $_ENV['USER_NAME'];
    $this->password = $_ENV['USER_PASSWORD'];
    $this->servername = getenv('SERVER_NAME');
    $this->makeConnection();
  }
  private function makeConnection()
  {
    try {
      $this->conn = new PDO("mysql:dbname=" . $this->dbname . ";host=" . $this->servername, $this->username, $this->password);
      echo "Connected successfully";
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
  public function getConn()
  {
    return $this->conn;
  }
  public function productFetch($POST)
  {
    $a = $this->getConn()->query("select price, name from product where id =" . $POST['products']);
    $b = $a->fetch();
    return $b;
  }
  public function customerFetch($POST)
  {
    $a = $this->getConn()->query("select group_id,fixed_discount,variable_discount from customer where id =" . $POST['customers']);
    $b = $a->fetch();
    return $b;
  }
  public function groupDiscountFetch($customerDetails)
  {
    $a =  $this->getConn()->query("select fixed_discount,variable_discount from customer_group where id =" . $customerDetails['group_id']);
    $b = $a->fetch();
    return $b;
  }
}
```

it has the makeconnection function and some functions for the fetches that we ended up needing.

- customerFetch()
- productFetch()
- groupDiscountFetch()
  i pulls and places into $a variable. transformes it with the $a->fecth() method and places into $b wich it returns. that's the basic formula for the fecth functions

## step 6

now that we can fetch our data and have some where-values for the new fetches we can display the price and then apply the discounts:

- we get 2 discounts from the customerFetch()
- we get 2 discounts from the groupDiscountFetch()
- we need to put this into an array so we can change the values where needed, cuz some are "NULL". and so we have them in one place and can apply logic to choose the best discount.
- we created a class for it (this is NOT how it started, this is after refactor)

- ## the priceHandler class

```php
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
        if ($this->outcome < 0) {
            $this->outcome = 0;
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
```

1. the refactorDiscounts()

---

here i refactor the null values to actual 0. maybe this is not needed in an other way but sinds i use 4 different allDiscounts keys i would get different keys back if i kicked the null values out. that makes it unpredictable and hard to see what to calculate on. so i somply set them to 0 and would always have the same 4 keys in my allDiscounts array.

---

2. the bestFixedDiscount()

---

here we check the 2 fixed_discounts, the group one and the one from the customer, and spit out the best one

---

3. th bestVariableDiscount()

---

here we do the same thing for the variable_discounts.

---

4. the calculate()

---

here we take the best values as parameters and the productPrice too. we calculate accordingly to find the best value for our user. if the outcome happens to be less then 0 then set it to 0. we are not going to pay them.

## step 7

here we are going to display the new price to the user

- ## the view

```php
<p>after discounts:</p>
<h1 style="color:green;">
    <?php
    if (isset($POST['submit'])) {
        echo "€ " . $outcome;
    }
    ?>
</h1>
```

given some green color to differentiate.

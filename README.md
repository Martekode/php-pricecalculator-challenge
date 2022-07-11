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

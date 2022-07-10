<?php require 'includes/header.php'; ?>

<!-- this is the view, try to put only simple if's and loops here.
Anything complex should be calculated in the model -->
<section>
    <h4>Hello <?php echo $user->getName() ?>,</h4>

    <p><a href="index.php?page=info">To info page</a></p>

    <p>Put your content here.</p>
</section>
<h2>pick your product</h2>
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
    <h1>
        <?php
        if (isset($POST['submit'])) {
            echo $productDetails['name'] . "<br>";
            echo "€ " . $productDetails['price'] / 100;
        }
        ?>
    </h1>
    <p>after discounts:</p>
    <h1 style="color:green;">
        <?php
        if (isset($POST['submit'])) {
            echo "€ " . $outcome;
        }
        ?>
    </h1>
</form>
<?php require 'includes/footer.php' ?>
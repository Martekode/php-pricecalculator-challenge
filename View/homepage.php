<?php require 'includes/header.php';?>

<!-- this is the view, try to put only simple if's and loops here.
Anything complex should be calculated in the model -->
<section>
    <h4>Hello <?php echo $user->getName()?>,</h4>

    <p><a href="index.php?page=info">To info page</a></p>

    <p>Put your content here.</p>
</section>
<h2>pick your product</h2>
<select name="products" id="cars">
    <?php
        foreach ($productArray as $product) {
            $name = ucfirst($product->getName());
            echo "<option value=".$name.">" . $name . "</option>";
        }
    ?>
</select>
<h2>select the customer</h2>
<select name="customers" id="customers">
    <?php
        foreach ($customerArray as $customer) {
            $name = ucfirst($customer->getFirstName());
            $lastName = ucfirst($customer->getLastName());
            echo "<option value=".$name." ".$lastName . ">" . $name." ". $lastName . "</option>";
        }
    ?>
</select>
<?php require 'includes/footer.php'?>
<?php require 'includes/header.php';?>

<!-- this is the view, try to put only simple if's and loops here.
Anything complex should be calculated in the model -->
<section>
    <h4>Hello <?php echo $user->getName()?>,</h4>

    <p><a href="index.php?page=info">To info page</a></p>

    <p>Put your content here.</p>
</section>



<h2>Pick your product :</h2>
<form method="post">
<select name="product" id="cars">
    <?php
    foreach ($productArray as $product) {
        $name = ucfirst($product->getName());
        $price = ($product->getPrice());
        echo "<option value=".$price.">" . $name . "</option>";
    }
    ?>
</select>
<h2>Select the customer :</h2>
<select name="customers" id="customers">
    <?php
    foreach ($customerArray as $customer) {
        $name = ucfirst($customer->getFirstName());
        $lastName = ucfirst($customer->getLastName());
        echo "<option value=".$name." ".$lastName . ">" . $name." ". $lastName . "</option>";
    }
    ?>
</select>
<br><button style="margin-top: 20px" name="submit">show price</button>
</form>
<h1>
    <?php
       if (isset($POST['submit'])) {
            echo "Total Price : " . "€" . $POST['product']/100;
       }
       ?>
</h1>



<?php require 'includes/footer.php'?>


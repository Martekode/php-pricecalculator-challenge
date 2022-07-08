<?php require 'includes/header.php'; require 'Model/Product.php';?>

<!-- this is the view, try to put only simple if's and loops here.
Anything complex should be calculated in the model -->
<section>
    <h4>Hello <?php echo $user->getName()?>,</h4>

    <p><a href="index.php?page=info">To info page</a></p>

    <p>Put your content here.</p>
</section>



<?php
$productArray = [];
while ($row = $sqlResult->fetch()) {
    //  print "<p>Name: {$row[0]} {$row[1]}</p>";

    $productArray[]= new Product($row[0],$row[1]);
}
var_dump($productArray);
?>
<?php require 'includes/footer.php'?>


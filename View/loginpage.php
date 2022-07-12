<?php require 'includes/header.php' ?>
<section>
    <h4>login page</h4>

    <p><a href="index.php">Back to homepage</a></p>
    <form method="post">
        <label for="username">Username</label>
        <select name="usernames">
            <?php foreach ($customerArray2 as $customer) : ?>
                <option value="<?= $customer->getName() ?>"><?= $customer->getName(); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="password">Password</label>
        <input type="text" name="password">
        <br><button name="login">Login</button>
    </form>
    <p>don't have an account? Make one here:</p>
    <p><a href="index.php?page=registerpage">register</a></p>

</section>
<?php require 'includes/footer.php' ?>
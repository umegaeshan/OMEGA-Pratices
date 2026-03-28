<nav style="background: #333; color: white; padding: 15px; display: flex; justify-content: space-between;">
    <div>
        <strong>OMEGA SHOP</strong>
    </div>
    <div>
        <a href="home.php" style="color: white; margin-right: 55px;">Home</a>

        <?php if (isset($_SESSION['role'])): ?>

            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="../admin/admin_dashbord.php" style="color: yellow; margin-right: 55px;">Admin Dashboard</a>
                <a href="../admin/manage_products.php" style="color: yellow; margin-right: 55px;">Manage Products</a>
                <a href="../admin/add_product.php" style="color: yellow; margin-right: 55px;">Add Products</a>
            <?php endif; ?>

            <?php if ($_SESSION['role'] == 'user'): ?>
                <a href="../user/products.php" style="color: white; margin-right: 55px;">Products</a>
                <a href="../user/my_orders.php" style="color: white; margin-right: 55px;">My Orders</a>
                <a href="../user/cart.php" style="color: white; margin-right: 55px;">Cart</a>
            <?php endif; ?>


            <a href="../public/profile.php" style="color: white; margin-right: 550px;">Profile</a>

            <span style="margin-left: 10px;margin-left: 50px;">Hi, <?php echo $_SESSION['username']; ?></span>
            <a href="../public/login.php" style="background: red; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Logout</a>

        <?php else: ?>
            <a href="../public/login.php" style="color: white; margin-right: 15px;">Login</a>
            <a href="../public/register.php" style="background: blue; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Register</a>
        <?php endif; ?>
    </div>
</nav>
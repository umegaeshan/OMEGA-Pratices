<nav style="background: #333; color: white; padding: 15px; display: flex; justify-content: space-between;">
    <div>
        <strong>OMEGA SHOP</strong>
    </div>
    <div>
        <a href="home.php" style="color: white; margin-right: 15px;">Home</a>

        <?php if (isset($_SESSION['role'])): ?>

            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="admin_dashbord.php" style="color: yellow; margin-right: 15px;">Admin Dashboard</a>
                <a href="manage_products.php" style="color: yellow; margin-right: 15px;">Manage Products</a>
            <?php endif; ?>

            <?php if ($_SESSION['role'] == 'user'): ?>
                <a href="my_orders.php" style="color: white; margin-right: 15px;">My Orders</a>
                <a href="cart.php" style="color: white; margin-right: 15px;">Cart</a>
            <?php endif; ?>

            <a href="profile.php" style="color: white; margin-right: 15px;">Profile</a>
            <a href="logout.php" style="background: red; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Logout</a>
            <span style="margin-left: 10px;">Hi, <?php echo $_SESSION['username']; ?></span>

        <?php else: ?>
            <a href="login.php" style="color: white; margin-right: 15px;">Login</a>
            <a href="register.php" style="background: blue; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Register</a>
        <?php endif; ?>
    </div>
</nav>
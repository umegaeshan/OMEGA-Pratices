<?php
session_start();
include_once("../connect/connect.php");

$whereClause = "WHERE 1=1";

if (isset($_GET['category']) && $_GET['category'] != '') {
    $cat = $_GET['category'];
    $whereClause .= " AND category = '$cat'";
}

if (isset($_GET['min_price']) && isset($_GET['max_price']) && $_GET['max_price'] != '') {
    $min = $_GET['min_price'];
    $max = $_GET['max_price'];
    $whereClause .= " AND price BETWEEN $min AND $max";
}

$sql = "SELECT * FROM products $whereClause ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Products | OMEGA</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
        }

        .main-container {
            display: flex;
            padding: 20px;
        }

        .filter-sidebar {
            width: 250px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-right: 20px;
            height: fit-content;
        }

        .product-grid {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .filter-group {
            margin-bottom: 15px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 8px;
            margin-bottom: 5px;
        }

        .btn-filter {
            background: #333;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        .btn-reset {
            background: #ccc;
            color: black;
            text-align: center;
            display: block;
            padding: 10px;
            text-decoration: none;
            margin-top: 10px;
        }

        .card {
            background: white;
            width: 220px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            text-align: center;
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
        }

        .price {
            color: green;
            font-weight: bold;
            font-size: 18px;
        }

        .new-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: red;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
        }

        .fav-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #ccc;
        }

        .fav-btn:hover {
            color: red;
        }

        .btn-cart {
            background: orange;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <?php include('../includes/navbar.php'); ?>

    <div class="main-container">

        <div class="filter-sidebar">
            <h3>Filter Products</h3>
            <form action="products.php" method="GET">

                <div class="filter-group">
                    <label>Category</label>
                    <select name="category">
                        <option value="">All Categories</option>
                        <option value="computer" <?php if (isset($_GET['category']) && $_GET['category'] == 'computer') echo 'selected'; ?>>Computers</option>
                        <option value="spares" <?php if (isset($_GET['category']) && $_GET['category'] == 'spares') echo 'selected'; ?>>Spare Parts</option>
                        <option value="accessories" <?php if (isset($_GET['category']) && $_GET['category'] == 'accessories') echo 'selected'; ?>>Accessories</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Price Range (Rs.)</label>
                    <input type="number" name="min_price" placeholder="Min" value="<?php if (isset($_GET['min_price'])) echo $_GET['min_price']; ?>">
                    <input type="number" name="max_price" placeholder="Max" value="<?php if (isset($_GET['max_price'])) echo $_GET['max_price']; ?>">
                </div>

                <button type="submit" class="btn-filter">Apply Filter</button>
                <a href="products.php" class="btn-reset">Reset Filters</a>
            </form>
        </div>

        <div class="product-grid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {


                    $is_new = false;
                    $product_date = new DateTime($row['created_at']);
                    $today = new DateTime();
                    $interval = $today->diff($product_date);

                    if ($interval->days <= 7) {
                        $is_new = true;
                    }
            ?>

                    <div class="card">
                        <?php if ($is_new): ?>
                            <span class="new-badge">NEW</span>
                        <?php endif; ?>

                        <form action="add_favorite.php" method="POST" style="display:inline;">
                            <input type="hidden" name="p_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="fav-btn">♥</button>
                        </form>

                        <img src="../uploads/<?php echo $row['image']; ?>" alt="Product">
                        <h4><?php echo $row['name']; ?></h4>
                        <p class="price">Rs. <?php echo number_format($row['price'], 2); ?></p>

                        <form action="cart.php" method="POST">
                            <input type="hidden" name="p_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="add_to_cart" class="btn-cart">Add to Cart</button>
                        </form>
                    </div>

            <?php
                }
            } else {
                echo "<h3>No products found matching your filter!</h3>";
            }
            ?>
        </div>
    </div>

</body>

</html>
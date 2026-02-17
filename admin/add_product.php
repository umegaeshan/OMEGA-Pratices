<?php
session_start();
include_once("../connect/connect.php");

// 1. Admin කෙනෙක්ද කියලා බලන ආරක්ෂක පියවර
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../public/login.php"); // ඇඩ්මින් නොවේ නම් එළියට
    exit();
}

$message = "";

// 2. Form එක Submit කළාම වැඩ කරන කොටස
if (isset($_POST['add_product_btn'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $category = $_POST['category'];

    // --- Image Upload Logic (පින්තූරය හැසිරවීම) ---

    // පින්තූරයේ නම ගන්නවා
    $image_name = $_FILES['image']['name'];

    // පින්තූරය තාවකාලිකව තියෙන තැන (Temp location)
    $image_temp = $_FILES['image']['tmp_name'];

    // පින්තූරය නවතින්න ඕන තැන (අපි හදපු 'uploads' folder එක)
    $target_folder = "../uploads/" . basename($image_name);

    // 3. Database එකට දත්ත යැවීම
    // created_at එක අපි Database එකේ Default දාලා තියෙන්නේ, ඒ නිසා ඒක ලියන්න ඕන නෑ.
    $sql = "INSERT INTO products (name, price, category, image) VALUES ('$name', '$price', '$category', '$image_name')";

    if (mysqli_query($conn, $sql)) {
        // Database එකට ගියාට පස්සේ, ඇත්ත පින්තූරය Folder එකට යවනවා
        if (move_uploaded_file($image_temp, $target_folder)) {
            $message = "<span style='color:green;'>Product Added Successfully!</span>";
        } else {
            $message = "<span style='color:orange;'>Product added to DB, but Image upload failed!</span>";
        }
    } else {
        $message = "<span style='color:red;'>Database Error: " . mysqli_error($conn) . "</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Product | Admin</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .form-container {
            background: white;
            width: 400px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #218838;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <center>
            <h2>Add New Product</h2>
        </center>

        <p style="text-align:center;"><?php echo $message; ?></p>

        <form action="add_product.php" method="post" enctype="multipart/form-data">

            <label>Product Name</label>
            <input type="text" name="name" required placeholder="Enter product name">

            <label>Price (Rs.)</label>
            <input type="number" name="price" required placeholder="Enter price">

            <label>Category</label>
            <select name="category" required>
                <option value="" disabled selected>Select Category</option>
                <option value="computer">Computer</option>
                <option value="spares">Spare Parts</option>
                <option value="accessories">Accessories</option>
            </select>

            <label>Product Image</label>
            <input type="file" name="image" required>

            <button type="submit" name="add_product_btn">Add Product Now</button>

            <a href="admin_dashbord.php" class="back-link">Back to Dashboard</a>
        </form>
    </div>

</body>

</html>
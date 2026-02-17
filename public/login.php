<?php
session_start();
include_once("../connect/connect.php");

$message = "";

if (isset($_POST["login_btn"])) {
    $email =  $_POST["email"];
    $password = $_POST["password"];


    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);



        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["role"] = $row["role"];


            if ($row["role"] == "admin") {
                header("Location: ../admin/admin_dashbord.php");
                exit();
            } else {
                header("Location: ../user/home.php");
                exit();
            }
        } else {
            $message = "Wrong password! Insert again.";
        }
    } else {

        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page | OMEGA</title>
</head>

<body>

    <div>
        <center>
            <h3><?php echo $message; ?></h3>
            <h1>Login Now </h1>
            <form action="login.php" method="post">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                    <br><br>

                    <label for="password"> Password </label>
                    <input type="password" name="password" required>
                    <br><br>
                    <div>
                        <button type="submit" name="login_btn">Login Now </button>
                    </div>

                    <div>
                        <p>i dont have an account ? <a href="register.php"> Register Now </a></p>
                    </div>
                </div>
            </form>

        </center>
    </div>
</body>

</html>
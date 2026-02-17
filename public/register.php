<?php

session_start();

include_once("../connect/connect.php");

$message = "";

if (isset($_POST['register_btn'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile_no'];
    $role = $_POST['role'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check_email) == 0) {

        $sql = "INSERT INTO users(username, email, password, mobile_no, role) VALUES('$username', '$email', '$hashed_password', '$mobile_no', '$role')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            $message = "Registration Unsuccessful! " . mysqli_error($conn);
        }
    } else {
        $message = "This Email Already Registered!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page | OMEGA</title>
</head>

<body>
    <center>
        <h3><?php echo $message ?></h3>
        <h1> Register Now </h1>
        <form action="register.php" method="post">

            <div>
                <label> Username</label>
                <input type="text" name="username" required>
                <br><br>

                <label>Email</label>
                <input type="email" name="email" required>
                <br><br>

                <label> Password</label>
                <input type="password" name="password" required>
                <br><br>

                <label>Mobile No</label>
                <input type="rext" name="mobile_no" required>
                <br><br>

                <label>User Role</label>
                <select name="role">
                    <option value="" selected>Select User Role</option>
                    <option value="user"> User</option>
                    <option value="admin">Admin</option>
                </select>
                <br><br>

            </div>

            <div>
                <button type="submit" name="register_btn">Register Now</button>
            </div>

            <div>
                <p>Alrady i have a account ? <a href="login.php" name="login_btn"> Login Now ! </a></p>
            </div>
        </form>

    </center>



</body>

</html>
<?php

session_start();

include_once("../connect/connect.php");

$message = "";

if (isset($_POST['register_btn'])) {

    $username = $_POST['username '];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile_no'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check_email) == 0) {

        $sql = "INSERT INTO users(username,email,password,mobile_no) VALUES('$username','$email','$hashed_password','$mobile_no');";
        if (mysqli_query($conn, $sql)) {
            $message = "Regestration Successfull !";
        } else {
            $message = "Registration Unsuccessfull !";
        }
    } else {
        $message = "This Email Alrady Registerd !";
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
        <h1> Register Now </h1>
        <form action="register.php" methos="post">

            <div>
                <lable> Username</lable>
                <input type="text" name="username">
                <br><br>

                <lable>Email</lable>
                <input type="email" name="email">
                <br><br>

                <lable> Password</lable>
                <input type="password" name="password">
                <br><br>

                <lable>Mobile No</lable>
                <input type="rext" name="mobile_no">
                <br><br>

                <lable>User Role</lable>
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
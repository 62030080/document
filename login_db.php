<?php 
    session_start();
    include('dbconfig.php');

    $errors = array();

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $psw = mysqli_real_escape_string($mysqli, $_POST['psw']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }

        if (empty($psw)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $password = md5($psw);
            $query = "SELECT * FROM staff WHERE username = '$username' AND passwd = '$password' ";
            $result = mysqli_query($mysqli, $query);

            if (mysqli_num_rows($result) == 1) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "Your are now logged in";
                header("location: mainpage.php");
            } else {
                array_push($errors, "Wrong Username or Password");
                $_SESSION['error'] = "Wrong Username or Password!";
                header("location: loginpage.php");
            }
        } else {
            array_push($errors, "Username & Password is required");
            $_SESSION['error'] = "Username & Password is required";
            header("location: loginpage.php");
        }
    }

?>

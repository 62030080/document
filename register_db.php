<?php 
    session_start();
    include('dbconfig.php');
    
    $errors = array();

    if (isset($_POST['register_user'])) {
        $stc = mysqli_real_escape_string($mysqli, $_POST['stc']);
        $stn = mysqli_real_escape_string($mysqli, $_POST['stn']);
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $psw = mysqli_real_escape_string($mysqli, $_POST['psw']);
        $pswrepeat = mysqli_real_escape_string($mysqli, $_POST['pswrepeat']);

        if (empty($username)) {
            array_push($errors, "Username is required");
            $_SESSION['error'] = "Username is required";
        }
        if (empty($psw)) {
            array_push($errors, "Password is required");
            $_SESSION['error'] = "Password is required";
        }
        if ($psw != $pswrepeat) {
            array_push($errors, "The two passwords do not match");
            $_SESSION['error'] = "The two passwords do not match";
        }

        $user_check_query = "SELECT * FROM staff WHERE username = '$username'";
        $query = mysqli_query($mysqli, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['username'] === $username) {
                array_push($errors, "Username already exists");
            }
        }

        if (count($errors) == 0) {
            $password = md5($psw);

            $sql = "INSERT INTO staff (stf_code, stf_name, username, passwd) VALUES ('$stc','$stn','$username', '$password')";
            mysqli_query($mysqli, $sql);

            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: mainpage.php');
        } else {
            header("location: register.php");
        }
    }

?>

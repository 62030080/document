<?php 
    session_start();
    include('dbconfig.php'); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, intitial-scale=1.0">
  <title>สมัครสมาชิก</title>
</head>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: center;
  width: 100%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* Clear floats */
/* .clearfix::after {
  content: "";
  clear: both;
  display: table;
} */

/* Change styles for cancel button and signup button on extra small screens */
/* @media screen and (max-width: 1000px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }
} */
</style>
<body>

<form action="register_db.php" style="border:1px solid #ccc" method="post">
  <?php include('errors.php'); ?>
  <?php if (isset($_SESSION['error'])) : ?>
    <div class="error">
      <h3>
        <?php 
          echo $_SESSION['error'];
          unset($_SESSION['error']);
        ?>
      </h3>
    </div>
  <?php endif ?>
  <div class="container">
    <h1>สมัครสมาชิก</h1>
    <p>กรุณากรอกข้อมูลเพื่อสมัครสมาชิก</p>
    <hr>

    <label for="staff code"><b>Staff Code</b></label>
    <input type="text" class="form-control" name="stc" id="stc" require>
    <label for="staff name"><b>Staff Name</b></label>
    <input type="text" class="form-control" name="stn" id="stn" require>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter username" name="username" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label for="pswrepeat"><b>Confirm Password</b></label>
    <input type="password" placeholder="Confirm Password" name="pswrepeat" required>
    
    <!-- <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label> -->
    
    <!-- <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p> -->
    <button type="submit" class="signupbtn" name="register_user">Register</button>
    <p><a href="loginpage.php">Already a member?</a></p>
  </div>
</form>

</body>
</html>

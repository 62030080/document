<?php 
    session_start();

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: loginpage.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: loginpage.php');
    }
?>
<?php
require_once("dbconfig.php");

// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะเพิ่ม
if ($_POST){
    // $sid = $_POST['sid'];
    $stc = $_POST['stc'];
    $stn = $_POST['stn'];
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $psw = mysqli_real_escape_string($mysqli, $_POST['psw']);
    $pswrepeat = mysqli_real_escape_string($mysqli, $_POST['pswrepeat']);
    $password = md5($psw);

    // insert a record by prepare and bind
    // The argument may be one of four types:
    //  i - integer
    //  d - double
    //  s - string
    //  b - BLOB

    // ในส่วนของ INTO ให้กำหนดให้ตรงกับชื่อคอลัมน์ในตาราง actor
    // ต้องแน่ใจว่าคำสั่ง INSERT ทำงานใด้ถูกต้อง - ให้ทดสอบก่อน
    $sql = "INSERT 
            INTO staff (stf_code, stf_name, username ,passwd) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $stc, $stn, $username, $password);
    $stmt->execute();

    // redirect ไปยัง actor.php
    header("location: staffpage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>เพิ่มบุคลากร</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>เพิ่มบุคลากร</h1>
        <form action="addstaff.php" method="post">
            <!-- <div class="form-group">
                <label for="sid">id</label>
                <input type="text" class="form-control" name="sid" id="sid">
            </div> -->
            <div class="form-group">
                <label for="stc">Staff Code</label>
                <input type="text" class="form-control" name="stc" id="stc" require>
            </div>
            <div class="form-group">
                <label for="stn">Staff Name</label>
                <input type="text" class="form-control" name="stn" id="stn" require>
            </div>
            <div class="form-group">
                <label for="username"><b>Username</b></label>
                <input type="text" class="form-control" placeholder="Enter username" name="username" required>
            </div>
            <div class="form-group">
                <label for="psw"><b>Password</b></label>
                <input type="password" class="form-control" placeholder="Enter Password" name="psw" required>
            </div>
            <div class="form-group">
                <label for="pswrepeat"><b>Confirm Password</b></label>
                <input type="password" class="form-control" placeholder="Confirm Password" name="pswrepeat" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
</body>

</html>
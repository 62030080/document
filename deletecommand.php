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

// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะลบ
if ($_POST){
    // ดึงค่าที่โพสจากฟอร์มตาม name ที่กำหนดในฟอร์มมากำหนดให้ตัวแปร $id
    $did = $_POST['id'];

    // เตรียมคำสั่ง DELETE
    $sql = "DELETE 
            FROM documents 
            WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $did);
    $stmt->execute();

    // redirect ไปยังหน้า actor.php
    header("location: commandpage.php");
} else {
    // ดึงค่าที่ส่งผ่านมาทาง query string มากำหนดให้ตัวแปร $id
    $did = $_GET['id'];
    $sql = "SELECT *
            FROM documents
            WHERE id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $did);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_object();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ลบคำสั่งแต่งตั้ง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>ลบคำสั่งแต่งตั้ง</h1>
        <table class="table table-hover">
            <tr>
                <th style='width:120px'>id</th>
                <td><?php echo $row->id;?></td>
            </tr>
            <tr>
                <th>Document Number</th>
                <td><?php echo $row->doc_num;?></td>
            </tr>
            <tr>
                <th>Document Title</th>
                <td><?php echo $row->doc_title;?></td>
            </tr>
            <tr>
                <th>Document Start Date</th>
                <td><?php echo $row->doc_start_date;?></td>
            </tr>
            <tr>
                <th>Document To Date</th>
                <td><?php echo $row->doc_to_date;?></td>
            </tr>
            <tr>
                <th>Document Status</th>
                <td><?php echo $row->doc_status;?></td>
            </tr>
            <tr>
                <th>Document File Name</th>
                <td><?php echo $row->doc_file_name;?></td>
            </tr>
        </table>
        <form action="deletecommand.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <input type="submit" value="Confirm delete" class="btn btn-danger">
            <button type="button" class="btn btn-warning" onClick="window.history.back()">Cancel Delete</button>
        </form>
</body>

</html>
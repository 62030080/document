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
<!DOCTYPE html>
<html lang="en">

<head>
    <title>จัดการคำสั่งแต่งตั้ง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong> <?php echo $_SESSION['username']; ?></strong></p>
        <p><a href="mainpage.php?logout='1'" style="color : red;">Logout</a></p>
    <?php endif ?>
    <div class="container">
        <h1>จัดการคำสั่งแต่งตั้ง |<a href='mainpage.php'><span class='glyphicon glyphicon-home' aria-hidden='true'></span></a>
        | <a href='addcommand.php'><span class='glyphicon glyphicon-plus'></span></a></h1>
        <form action="#" method="post">
            <input type="text" name="kw" placeholder="ใส่เลขที่คำสั่งหรือชื่อคำสั่ง" value="">
            <input type="submit">
        </form>

        <?php
        require_once("dbconfig.php");

        // ตัวแปร $_POST เป็นตัวแปรอะเรย์ของ php ที่มีค่าของข้อมูลที่โพสมาจากฟอร์ม
        // ดึงค่าที่โพสจากฟอร์มตาม name ที่กำหนดในฟอร์มมากำหนดให้ตัวแปร $kw
        // ใส่ % เพือเตรียมใช้กับ LIKE
        if ($_POST) {
            $kw = "%{$_POST['kw']}%";
        }
        else {$kw = "%";}

        // เตรียมคำสั่ง SELECT ที่ถูกต้อง(ทดสอบให้แน่ใจ)
        // ถ้าต้องการแทนที่ค่าของตัวแปร ให้แทนที่ตัวแปรด้วยเครื่องหมาย ? 
        // concat() เป็นฟังก์ชั่นสำหรับต่อข้อความ
        $sql = "SELECT *
                FROM documents
                WHERE concat(doc_num, doc_title) LIKE ? 
                ORDER BY id DESC";
        // $sql = "SELECT *
        // FROM ((documents LEFT JOIN doc_staff)LEFT JOIN staff)
        // WHERE concat(doc_num, doc_title,stf_name) LIKE ? 
        // ORDER BY id DESC";
        // Prepare query
        // Bind all variables to the prepared statement
        // Execute the statement
        // Get the mysqli result variable from the statement
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        // Retrieves a result set from a prepared statement
        $result = $stmt->get_result();
        
        // num_rows เป็นจำนวนแถวที่ได้กลับคืนมา
        if ($result->num_rows == 0) {
            echo "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s).";
            // สร้างตัวแปรเพื่อเก็บข้อความ html 
            // <th scope='col'>#</th>
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>doc_num</th>
                                <th scope='col'>doc_title</th>
                                <th scope='col'>doc_start_date</th>
                                <th scope='col'>doc_to_date</th>
                                <th scope='col'>doc_status</th>
                                <th scope='col'>doc_file_name</th>
                                <th scope='col'>doc link</th>
                                <th scope='col'><center>edit/delete/add director</center></th>
                            </tr>
                        </thead>
                        <tbody>";
            // 
            $i = 1; 

            // ดึงข้อมูลออกมาทีละแถว และกำหนดให้ตัวแปร row 
            while($row = $result->fetch_object()){
                $file_link= "http://localhost/document/upfile/" . $row->doc_file_t_name;
                $table.= "<tr>";
                // $table.= "<td>" . $i++ . "</td>";
                // $table.= "<td>$row->id</td>";
                $table.= "<td>$row->doc_num</td>";
                $table.= "<td>$row->doc_title</td>";
                $table.= "<td>$row->doc_start_date</td>";
                $table.= "<td>$row->doc_to_date</td>";
                $table.= "<td>$row->doc_status</td>";
                $table.= "<td>$row->doc_file_name</td>";
                $table.= "<td><a href='$file_link'>$row->doc_file_name</td>";
                $table.= "<td><center>";
                $table.= "<a href='editcommand.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a href='deletecommand.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a href='addstafftodoc.php?id=$row->id'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>";
                $table.= "</center></td>";
                $table.= "</tr>";
            }

            $table.= "</tbody>";
            $table.= "</table>";
            
            echo $table;
        }
        ?>
    </div>
</body>

</html>
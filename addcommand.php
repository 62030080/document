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
    // $did = $_POST['did'];
    $dnum = $_POST['dnum'];
    $dtitle = $_POST['dtitle'];
    $dsdate = $_POST['dsdate'];
    // $dtdate = $_POST['dtdate'];
    // $dstatus = $_POST['dstatus'];

//------------------------------------------------------------------------------------
    $target_dir = "upfile/"; //ตำแหน่งที่เอาไฟล์ไปเก็บ
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); //
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // เอานามสกุลไฟล์ที่ upload
    $realname = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["tmp_name"]);
    $tmp_file_name =  "upfile/" . substr($_FILES["fileToUpload"]["tmp_name"],5) . ".$fileType";
    $tmp_f_n_to_upload = substr($tmp_file_name,7);
    // print_r($tmp_f_n_to_upload);
    // echo "<br/>";
    // if($fileType == "pdf"){move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $tmp_file_name);}
    // else{echo "<script type='text/javascript'>alert('$alms');</script>";}
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $tmp_file_name);
    // if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $tmp_file_name)) {
    // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    // } else {
    // echo "Sorry, there was an error uploading your file.";
    // }
    // $dfname = $realname;
    // $dftname = $tmp_f_n_to_upload;
    // insert a record by prepare and bind
    // The argument may be one of four types:
    //  i - integer
    //  d - double
    //  s - string
    //  b - BLOB

    // ในส่วนของ INTO ให้กำหนดให้ตรงกับชื่อคอลัมน์ในตาราง actor
    // ต้องแน่ใจว่าคำสั่ง INSERT ทำงานใด้ถูกต้อง - ให้ทดสอบก่อน
    $sql = "INSERT 
            INTO documents ( doc_num, doc_title, doc_start_date, doc_to_date, doc_status, doc_file_name, doc_file_t_name) 
            VALUES (?, ?, ?, NULL, 'Active', ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss", $dnum, $dtitle, $dsdate, $realname, $tmp_f_n_to_upload);
    $stmt->execute();

    // redirect ไปยัง actor.php
    // echo $mysqli->insert_id;
    // header("location: addstafftodoc.php?id=$mysqli->insert_id");
    
    header("location: commandpage.php"); // ต้องไม่มีการพิมพ์อะไรออกมาก่อนหน้านี้เลย (echo)
}
?>
<!-- --------------- -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>เพิ่มคำสั่งแต่งตั้ง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- <button type="button" class="btn" href="http://localhost/document/commandpage.php">Back</button> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>เพิ่มคำสั่งแต่งตั้ง</h1>
        <form action="addcommand.php" method="post" enctype="multipart/form-data">
            <!-- <div class="form-group">
                <label for="did">id</label>
                <input type="text" class="form-control" name="did" id="did">
            </div> -->
            <div class="form-group">
                <label for="dnum">Document Number</label>
                <input type="text" class="form-control" name="dnum" id="dnum">
            </div>
            <div class="form-group">
                <label for="dtitle">Document Title</label>
                <input type="text" class="form-control" name="dtitle" id="dtitle">
            </div>
            <div class="form-group">
                <label for="dsdate">Document Start Date</label>
                <input type="date" class="form-control" name="dsdate" id="dsdate">
            </div>
            <!-- <div class="form-group">
                <label for="dtdate">Document To Date</label>
                <input type="date" class="form-control" name="dtdate" id="dtdate">
            </div>
            <div class="form-group">
                <label for="dstatus">Document Status</label>
                <input type="text" class="form-control" name="dstatus" id="dstatus" value="Active">
            </div> -->
            <!-- <div class="form-group">
                <label for="dfname">Document File Name</label>
                <input type="text" class="form-control" name="dfname" id="dfname">
            </div> -->
            <!-- <div class="form-group">
                <label for="">เพิ่มไฟล์</label><br>
                <a href="addcommandfile.php" class="btn btn-primary">Add file</a>>
            </div> -->
            <div class="form-group">
                <label for="docfile">เพิ่มเอกสาร</label>
                <input type="file" name="fileToUpload" id="fileToUpload" accept="application/pdf"><br>
                <!-- <input type="submit" value="Upload file" name="submit"> -->
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
        
</body>

</html>
<!-- ------------------------------------------------------------------------------------------ -->

<!-- --------------------------------------------------------------------------------------------- -->
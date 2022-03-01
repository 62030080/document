<?php
require_once("dbconfig.php");

// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะลบ
if ($_POST){
    $did = $_POST['did'];
    $dnum = $_POST['dnum'];
    $dtitle = $_POST['dtitle'];
    $dsdate = $_POST['dsdate'];
    $dtdate = $_POST['dtdate'];
    $dstatus = $_POST['dstatus'];
    $dfname = $_POST['dfname'];

    $sql = "UPDATE documents 
            SET id = ?,
                doc_num = ?,
                doc_title = ?,
                doc_start_date = ?,
                doc_to_date = ?,
                doc_status = ?,
                doc_file_name = ?,  
            WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("issssss", $did, $dnum, $dtitle, $dsdate, $dtdate, $dstatus, $dfname);
    $stmt->execute();

    header("location: commandpage.php");
} else {
    $id = $_GET['id'];
    $sql = "SELECT *
            FROM documents
            WHERE id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_object();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Command</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Edit Command</h1>
        <form action="editstaff.php" method="post">
        <div class="form-group">
                <label for="did">id</label>
                <input type="text" class="form-control" name="did" id="did">
            </div>
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
            <div class="form-group">
                <label for="dtdate">Document To Date</label>
                <input type="date" class="form-control" name="dtdate" id="dtdate">
            </div>
            <div class="form-group">
                <label for="dstatus">Document Status</label>
                <input type="text" class="form-control" name="dstatus" id="dstatus">
            </div>
            <div class="form-group">
                <label for="dfname">Document File Name</label>
                <input type="text" class="form-control" name="dfname" id="dfname">
            </div>
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <button type="submit" class="btn btn-success">Update</button>
        </form>
</body>

</html>
<?php
require_once("dbconfig.php");
$id = $_GET['id'];
if ($_POST){
    $did = $_POST['doc_id'];
    echo "<pre>";
    print_r($_POST);
for($i=0;$i<count($_POST['staff_id']);$i++){
    // echo $_POST['staff_id'][$i];
    $sql = "INSERT 
    INTO doc_staff (doc_id, stf_id) 
    VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $did, $_POST['staff_id'][$i]);
    $stmt->execute();
}

}
?>

<form action="#" method="post">
<input type="hidden" name="doc_id" value="<?php echo $id; ?>">
<?php

$sql = "SELECT *
        FROM staff
        ORDER BY id";
        $stmt = $mysqli->prepare($sql);
        // $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
// <!-- select * from staff เปลี่ยน value และ aaa ตามฟิลด์ -->
// <!-- <input type="checkbox" name="staff_id[]" value="1">aaa<br> -->
while($row = $result->fetch_object()){ 
    echo "<input type='checkbox' name='staff_id[]' value='$row->id'>$row->stf_name<br>";
}
?>
<input type="submit">
</form>

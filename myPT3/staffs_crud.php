<?php 
include_once 'database.php';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Create
  if (isset($_POST['create'])) {
    $stmt = $conn->prepare("INSERT INTO tbl_staffs_a198548_pt2 (FLD_STAFF_ID, FLD_STAFF_NAME, FLD_POSITION, FLD_STAFF_PHONENUMBER)
                            VALUES(:sid, :name, :position, :phone)");

    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

    $sid = $_POST['sid'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];

    $stmt->execute();
    header("Location: staffs.php");
  }

  // Update
  if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE tbl_staffs_a198548_pt2 SET
                              FLD_STAFF_ID = :sid,
                              FLD_STAFF_NAME = :name,
                              FLD_POSITION = :position,
                              FLD_STAFF_PHONENUMBER = :phone
                            WHERE FLD_STAFF_ID = :oldsid");

    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);

    $sid = $_POST['sid'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];
    $oldsid = $_POST['oldsid'];

    $stmt->execute();
    header("Location: staffs.php");
  }

  // Delete
  if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM tbl_staffs_a198548_pt2 WHERE FLD_STAFF_ID = :sid");

    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $sid = $_GET['delete'];

    $stmt->execute();
    header("Location: staffs.php");
  }

  // Edit
  if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a198548_pt2 WHERE FLD_STAFF_ID = :sid");

    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $sid = $_GET['edit'];

    $stmt->execute();
    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
  }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$conn = null;
?>

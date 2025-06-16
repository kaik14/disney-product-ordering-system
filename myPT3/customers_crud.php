<?php
include_once 'database.php';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Create
  if (isset($_POST['create'])) {
    $stmt = $conn->prepare("INSERT INTO tbl_customers_a198548_pt2 (FLD_CUSTOMER_ID, FLD_CUSTOMER_NAME, FLD_CUSTOMER_PHONENUMBER)
                            VALUES(:cid, :name, :phone)");

    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

    $cid = $_POST['cid'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $stmt->execute();
  }

  // Update
  if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE tbl_customers_a198548_pt2 SET 
                              FLD_CUSTOMER_ID = :cid, 
                              FLD_CUSTOMER_NAME = :name, 
                              FLD_CUSTOMER_PHONENUMBER = :phone 
                            WHERE FLD_CUSTOMER_ID = :oldcid");

    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':oldcid', $oldcid, PDO::PARAM_STR);

    $cid = $_POST['cid'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $oldcid = $_POST['oldcid'];

    $stmt->execute();

    header("Location: customers.php");
  }

  // Delete
  if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM tbl_customers_a198548_pt2 WHERE FLD_CUSTOMER_ID = :cid");

    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
    $cid = $_GET['delete'];

    $stmt->execute();

    header("Location: customers.php");
  }

  // Edit
  if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM tbl_customers_a198548_pt2 WHERE FLD_CUSTOMER_ID = :cid");

    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
    $cid = $_GET['edit'];

    $stmt->execute();

    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$conn = null;
?>

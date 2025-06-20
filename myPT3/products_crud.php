<?php

include_once 'database.php';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create
if (isset($_POST['create'])) {
  try {
    $stmt = $conn->prepare("INSERT INTO tbl_products_a198548_pt2 (
      FLD_PRODUCT_ID, FLD_PRODUCT_NAME, FLD_PRICE, FLD_BRAND,
      FLD_TYPE, FLD_DESCRIPTION, FLD_QUANTITY
    ) VALUES (:pid, :name, :price, :brand, :type, :description, :quantity)");

    $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price); // 用默认类型，允许小数
    $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price']; // 小数可以保留
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    $stmt->execute();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

// Update
if (isset($_POST['update'])) {
  try {
    $stmt = $conn->prepare("UPDATE tbl_products_a198548_pt2 SET 
      FLD_PRODUCT_ID = :pid,
      FLD_PRODUCT_NAME = :name,
      FLD_PRICE = :price,
      FLD_BRAND = :brand,
      FLD_TYPE = :type,
      FLD_DESCRIPTION = :description,
      FLD_QUANTITY = :quantity
      WHERE FLD_PRODUCT_ID = :oldpid");

    $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price); // 允许小数
    $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':oldpid', $oldpid, PDO::PARAM_STR);

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $oldpid = $_POST['oldpid'];

    $stmt->execute();

    header("Location: products.php");
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

// Delete
if (isset($_GET['delete'])) {
  try {
    $stmt = $conn->prepare("DELETE FROM tbl_products_a198548_pt2 WHERE FLD_PRODUCT_ID = :pid");
    $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
    $pid = $_GET['delete'];
    $stmt->execute();

    header("Location: products.php");
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

// Edit
if (isset($_GET['edit'])) {
  try {
    $stmt = $conn->prepare("SELECT * FROM tbl_products_a198548_pt2 WHERE FLD_PRODUCT_ID = :pid");
    $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
    $pid = $_GET['edit'];
    $stmt->execute();

    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

$conn = null;
?>

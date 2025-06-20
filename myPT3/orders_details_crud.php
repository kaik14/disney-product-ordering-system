<?php
include_once 'database.php';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Add product to order
if (isset($_POST['addproduct'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO tbl_orders_details_a198548_pt2(
            FLD_ORDER_DETAIL_ID, FLD_ORDER_ID, FLD_PRODUCT_ID, FLD_QUANTITY) 
            VALUES(:did, :oid, :pid, :quantity)");

        $stmt->bindParam(':did', $did, PDO::PARAM_STR);
        $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
        $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        $did = uniqid('D', true);
        $oid = $_POST['oid'];
        $pid = $_POST['pid'];
        $quantity = $_POST['quantity'];

        $stmt->execute();

        
        header("Location: orders_details.php?oid=$oid");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Delete product from order
if (isset($_GET['delete'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM tbl_orders_details_a198548_pt2 
            WHERE FLD_ORDER_DETAIL_ID = :did");

        $stmt->bindParam(':did', $did, PDO::PARAM_STR);
        $did = $_GET['delete'];
        $stmt->execute();

        header("Location: orders_details.php?oid=" . $_GET['oid']);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

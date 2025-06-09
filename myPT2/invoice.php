<?php
  include_once 'database.php';
?>
 
<!DOCTYPE html>
<html>
<head>
  <title>Disney Products Ordering System : Invoice</title>
</head>
<body>
  <center>
  Disney Products Sdn. Bhd. <br>
  Universiti Kebangsaan Malaysia (UKM) <br>
  43600 Bangi <br>
  Selangor <br>
  Malaysia <br>

    <hr>
    <?php
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT * FROM tbl_orders_a198548_pt2, tbl_staffs_a198548_pt2,
        tbl_customers_a198548_pt2, tbl_orders_details_a198548_pt2 WHERE
        tbl_orders_a198548_pt2.FLD_STAFF_ID = tbl_staffs_a198548_pt2.FLD_STAFF_ID AND
        tbl_orders_a198548_pt2.FLD_CUSTOMER_ID = tbl_customers_a198548_pt2.FLD_CUSTOMER_ID AND
        tbl_orders_a198548_pt2.FLD_ORDER_ID = tbl_orders_details_a198548_pt2.FLD_ORDER_ID AND
        tbl_orders_a198548_pt2.FLD_ORDER_ID = :oid");
      $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
      $oid = $_GET['oid'];
      $stmt->execute();
      $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
    Order ID: <?php echo $readrow['FLD_ORDER_ID'] ?><br>
    Order Date: <?php echo $readrow['FLD_ORDER_DATE'] ?>
    <hr>
    Staff: <?php echo $readrow['FLD_STAFF_NAME'] ?><br>
    Customer: <?php echo $readrow['FLD_CUSTOMER_NAME'] ?><br>
    Date: <?php echo date("d M Y"); ?>
    <hr>
    <table border="1">
      <tr>
        <td>No</td>
        <td>Product</td>
        <td>Quantity</td>
        <td>Price(RM)/Unit</td>
        <td>Total(RM)</td>
      </tr>
      <?php
      $grandtotal = 0;
      $counter = 1;
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_orders_details_a198548_pt2,
          tbl_products_a198548_pt2 WHERE 
          tbl_orders_details_a198548_pt2.FLD_PRODUCT_ID = tbl_products_a198548_pt2.FLD_PRODUCT_ID AND
          FLD_ORDER_ID = :oid");
        $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
        $oid = $_GET['oid'];
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
        echo "Error: " . $e->getMessage();
      }
      foreach($result as $detailrow) {
      ?>
      <tr>
        <td><?php echo $counter; ?></td>
        <td><?php echo $detailrow['FLD_PRODUCT_NAME']; ?></td>
        <td><?php echo $detailrow['FLD_QUANTITY']; ?></td>
        <td><?php echo number_format($detailrow['FLD_PRICE'], 2); ?></td>
        <td><?php echo number_format($detailrow['FLD_PRICE'] * $detailrow['FLD_QUANTITY'], 2); ?></td>
      </tr>
      <?php
        $grandtotal += $detailrow['FLD_PRICE'] * $detailrow['FLD_QUANTITY'];
        $counter++;
      }
      $conn = null;
      ?>
      <tr>
        <td colspan="4" align="right"><strong>Grand Total</strong></td>
        <td><strong><?php echo number_format($grandtotal, 2); ?></strong></td>
      </tr>
    </table>
    <hr>
    Computer-generated invoice. No signature is required.
  </center>
</body>
</html>

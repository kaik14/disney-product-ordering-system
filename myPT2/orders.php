<?php
  include_once 'orders_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Disney Products Ordering System : Orders</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr>
    <form action="orders.php" method="post">
      Order ID
      <input name="oid" type="text" readonly value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_ORDER_ID']; ?>"> <br>
      Order Date
      <input name="orderdate" type="text" readonly value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_ORDER_DATE']; else echo date('Y-m-d'); ?>"> <br>
      Staff
      <select name="sid">
      <?php
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a198548_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $staffrow) {
      ?>
        <option value="<?php echo $staffrow['FLD_STAFF_ID']; ?>"
          <?php if((isset($_GET['edit'])) && ($editrow['FLD_STAFF_ID'] == $staffrow['FLD_STAFF_ID'])) echo "selected"; ?>>
          <?php echo $staffrow['FLD_STAFF_NAME']; ?>
        </option>
      <?php
      }
      $conn = null;
      ?> 
      </select> <br>
      Customer
      <select name="cid">
      <?php
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM tbl_customers_a198548_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $custrow) {
      ?>
        <option value="<?php echo $custrow['FLD_CUSTOMER_ID']; ?>"
          <?php if((isset($_GET['edit'])) && ($editrow['FLD_CUSTOMER_ID'] == $custrow['FLD_CUSTOMER_ID'])) echo "selected"; ?>>
          <?php echo $custrow['FLD_CUSTOMER_NAME']; ?>
        </option>
      <?php
      }
      $conn = null;
      ?> 
      </select> <br>
      <?php if (isset($_GET['edit'])) { ?>
      <button type="submit" name="update">Update</button>
      <?php } else { ?>
      <button type="submit" name="create">Create</button>
      <?php } ?>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Order ID</td>
        <td>Order Date</td>
        <td>Staff</td>
        <td>Customer</td>
        <td>Actions</td>
      </tr>
      <?php
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT o.*, s.FLD_STAFF_NAME, c.FLD_CUSTOMER_NAME
                FROM tbl_orders_a198548_pt2 o
                JOIN tbl_staffs_a198548_pt2 s ON o.FLD_STAFF_ID = s.FLD_STAFF_ID
                JOIN tbl_customers_a198548_pt2 c ON o.FLD_CUSTOMER_ID = c.FLD_CUSTOMER_ID";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $orderrow) {
      ?>
      <tr>
        <td><?php echo $orderrow['FLD_ORDER_ID']; ?></td>
        <td><?php echo $orderrow['FLD_ORDER_DATE']; ?></td>
        <td><?php echo $orderrow['FLD_STAFF_NAME']; ?></td>
        <td><?php echo $orderrow['FLD_CUSTOMER_NAME']; ?></td>
        <td>
          <a href="orders_details.php?oid=<?php echo $orderrow['FLD_ORDER_ID']; ?>">Details</a>
          <a href="orders.php?edit=<?php echo $orderrow['FLD_ORDER_ID']; ?>">Edit</a>
          <a href="orders.php?delete=<?php echo $orderrow['FLD_ORDER_ID']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
        </td>
      </tr>
      <?php
      }
      $conn = null;
      ?>
    </table>
  </center>
</body>
</html>

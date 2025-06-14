<?php
  include_once 'customers_crud.php';
?>
 
<!DOCTYPE html>
<html>
<head>
  <title>Disney Products Ordering System : Customers</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr>
    <form action="customers.php" method="post">
      Customer ID
      <input name="cid" type="text" value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_ID']; ?>"> <br>
      Name
      <input name="name" type="text" value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_NAME']; ?>"> <br>
      Phone Number
      <input name="phone" type="text" value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_PHONENUMBER']; ?>"> <br>

      <?php if (isset($_GET['edit'])) { ?>
        <input type="hidden" name="oldcid" value="<?php echo $editrow['FLD_CUSTOMER_ID']; ?>">
        <button type="submit" name="update">Update</button>
      <?php } else { ?>
        <button type="submit" name="create">Create</button>
      <?php } ?>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Customer ID</td>
        <td>Name</td>
        <td>Phone Number</td>
        <td>Actions</td>
      </tr>
      <?php
      // Read from database
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_customers_a198548_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

      foreach ($result as $readrow) {
      ?>
      <tr>
        <td><?php echo $readrow['FLD_CUSTOMER_ID']; ?></td>
        <td><?php echo $readrow['FLD_CUSTOMER_NAME']; ?></td>
        <td><?php echo $readrow['FLD_CUSTOMER_PHONENUMBER']; ?></td>
        <td>
          <a href="customers.php?edit=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>">Edit</a>
          <a href="customers.php?delete=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
        </td>
      </tr>
      <?php } $conn = null; ?>
    </table>
  </center>
</body>
</html>

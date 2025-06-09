<?php
  include_once 'products_crud.php';
?>
 
<!DOCTYPE html>
<html>
<head>
  <title>Disney Products Ordering System : Products</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    <hr>
    <form action="products.php" method="post">
      Product ID
      <input name="pid" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_ID']; ?>"> <br>
      Name
      <input name="name" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_NAME']; ?>"> <br>
      Price
      <input name="price" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRICE']; ?>"> <br>
      Brand
      <select name="brand">
        <option value="Disney" <?php if(isset($_GET['edit']) && $editrow['FLD_BRAND']=="Disney") echo "selected"; ?>>Disney</option>
        <option value="Marvel" <?php if(isset($_GET['edit']) && $editrow['FLD_BRAND']=="Marvel") echo "selected"; ?>>Marvel</option>
        <option value="Hasbro" <?php if(isset($_GET['edit']) && $editrow['FLD_BRAND']=="Hasbro") echo "selected"; ?>>Hasbro</option>
        <option value="Disney Pixar" <?php if(isset($_GET['edit']) && $editrow['FLD_BRAND']=="Disney Pixar") echo "selected"; ?>>Disney Pixar</option>
      </select> <br>
      Type
      <select name="type">
        <?php 
          $types = ["Appliance","Backpack","Blanket","Car","Clock","Clothing","Doll","Figure","Figurine","Helmet","Jewelry","Keychain","Kitchenware","Lunchbox","Model","Mug","Playset","Puzzle","Replica","Snow Globe","Toy","Watch"];
          foreach ($types as $type) {
            echo "<option value=\"$type\"";
            if (isset($_GET['edit']) && $editrow['FLD_TYPE'] == $type) echo " selected";
            echo ">$type</option>";
          }
        ?>
      </select> <br>
      Quantity
      <input name="quantity" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_QUANTITY']; ?>"> <br>
      Description
      <input name="description" type="text" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_DESCRIPTION']; ?>"> <br>
      
      <?php if (isset($_GET['edit'])) { ?>
        <input type="hidden" name="oldpid" value="<?php echo $editrow['FLD_PRODUCT_ID']; ?>">
        <button type="submit" name="update">Update</button>
      <?php } else { ?>
        <button type="submit" name="create">Create</button>
      <?php } ?>
      <button type="reset">Clear</button>
    </form>
    <hr>
    <table border="1">
      <tr>
        <td>Product ID</td>
        <td>Name</td>
        <td>Price</td>
        <td>Brand</td>
        <td>Type</td>
        <td>Quantity</td>
        <td>Description</td>
        <td>Actions</td>
      </tr>
      <?php
      // Read
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_products_a198548_pt2");
        $stmt->execute();
        $result = $stmt->fetchAll();
      } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
      }

      foreach($result as $readrow) {
      ?>   
      <tr>
        <td><?php echo $readrow['FLD_PRODUCT_ID']; ?></td>
        <td><?php echo $readrow['FLD_PRODUCT_NAME']; ?></td>
        <td><?php echo $readrow['FLD_PRICE']; ?></td>
        <td><?php echo $readrow['FLD_BRAND']; ?></td>
        <td><?php echo $readrow['FLD_TYPE']; ?></td>
        <td><?php echo $readrow['FLD_QUANTITY']; ?></td>
        <td><?php echo $readrow['FLD_DESCRIPTION']; ?></td>
        <td>
          <a href="products_details.php?pid=<?php echo $readrow['FLD_PRODUCT_ID']; ?>">Details</a>
          <a href="products.php?edit=<?php echo $readrow['FLD_PRODUCT_ID']; ?>">Edit</a>
          <a href="products.php?delete=<?php echo $readrow['FLD_PRODUCT_ID']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
        </td>
      </tr>
      <?php } $conn = null; ?>
    </table>
  </center>
</body>
</html>

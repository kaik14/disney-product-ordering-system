<?php
  include_once 'database.php';
?>
 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Disney Products Ordering System : Product Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .panel {
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    }
    .panel-heading {
      background-color: #337ab7 !important;
      color: white !important;
      border-radius: 10px 10px 0 0;
      font-weight: bold;
    }
    .table > tbody > tr > td {
      vertical-align: middle;
      font-size: 15px;
    }
    .table > tbody > tr > td:first-child {
      font-weight: bold;
      width: 35%;
    }
    .well-sm {
      border-radius: 10px;
      background: #ffffff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .img-responsive {
      margin: 0 auto;
      max-height: 300px;
      border-radius: 10px;
    }
  </style>
</head>

<body>

<?php include_once 'nav_bar.php'; ?>

<?php
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT * FROM tbl_products_a198548_pt2 WHERE FLD_PRODUCT_ID = :pid");
  $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
  $pid = $_GET['pid'];
  $stmt->execute();
  $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;
?>

<div class="container">
  <div class="row">
    <!-- Image Column -->
    <div class="col-sm-6 text-center">
      <div class="well well-sm">
        <?php
        $image_path = "image/" . $readrow['FLD_PRODUCT_ID'] . ".jpg";
        if (file_exists($image_path)) {
          echo '<img src="' . $image_path . '" class="img-responsive">';
        } else {
          echo '<p>No image available</p>';
        }
        ?>
      </div>
    </div>

    <!-- Details Column -->
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading">Product Details</div>

        
        
        <div class="panel-body">
          Below are the specifications of the product.
        </div>



        <table class="table">
          <tr>
            <td>Product ID</td>
            <td><?php echo $readrow['FLD_PRODUCT_ID']; ?></td>
          </tr>
          <tr>
            <td>Name</td>
            <td><?php echo $readrow['FLD_PRODUCT_NAME']; ?></td>
          </tr>
          <tr>
            <td>Price</td>
            <td>RM <?php echo number_format($readrow['FLD_PRICE'], 2); ?></td>
          </tr>
          <tr>
            <td>Brand</td>
            <td><?php echo $readrow['FLD_BRAND']; ?></td>
          </tr>
          <tr>
            <td>Type</td>
            <td><?php echo $readrow['FLD_TYPE']; ?></td>
          </tr>
          <tr>
            <td>Quantity</td>
            <td><?php echo $readrow['FLD_QUANTITY']; ?></td>
          </tr>
          <tr>
            <td>Description</td>
            <td><?php echo $readrow['FLD_DESCRIPTION']; ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>

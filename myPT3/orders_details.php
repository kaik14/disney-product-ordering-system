<?php
  include_once 'orders_details_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Disney Products Ordering System : Orders Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .panel {
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }
    .panel-heading {
      background-color: #337ab7 !important;
      color: white !important;
      border-radius: 10px 10px 0 0;
      font-weight: bold;
    }
    .form-horizontal .control-label {
      text-align: left;
      font-weight: bold;
    }
    .btn {
      margin-right: 5px;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
      background-color: #f7f7f7;
    }
    .page-header h2 {
      font-weight: bold;
    }
  </style>
</head>
<body>

<?php include_once 'nav_bar.php'; ?>

<?php
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT * FROM tbl_orders_a198548_pt2
    JOIN tbl_staffs_a198548_pt2 ON tbl_orders_a198548_pt2.FLD_STAFF_ID = tbl_staffs_a198548_pt2.FLD_STAFF_ID
    JOIN tbl_customers_a198548_pt2 ON tbl_orders_a198548_pt2.FLD_CUSTOMER_ID = tbl_customers_a198548_pt2.FLD_CUSTOMER_ID
    WHERE FLD_ORDER_ID = :oid");
  $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
  $oid = $_GET['oid'];
  $stmt->execute();
  $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;
?>

<div class="container">
  <!-- Order Info Panel -->
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Order Details</div>
        <div class="panel-body">
                    Below are details of the order.
          </div>
          <table class="table">
            <tr><td><strong>Order ID</strong></td><td><?php echo $readrow['FLD_ORDER_ID']; ?></td></tr>
            <tr><td><strong>Order Date</strong></td><td><?php echo $readrow['FLD_ORDER_DATE']; ?></td></tr>
            <tr><td><strong>Staff</strong></td><td><?php echo $readrow['FLD_STAFF_NAME']; ?></td></tr>
            <tr><td><strong>Customer</strong></td><td><?php echo $readrow['FLD_CUSTOMER_NAME']; ?></td></tr>
          </table>
        </div>
      </div>
    </div>
  

  <!-- Add Product Form -->
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Add Product</div>
        <div class="panel-body">
          <form action="orders_details.php" method="post" class="form-horizontal" name="frmorder" id="frmorder" onsubmit="return validateForm();">
            <div class="form-group">
              <label for="prd" class="col-sm-3 control-label">Product</label>
              <div class="col-sm-9">
                <select name="pid" class="form-control" id="prd">
                  <option value="">Please select</option>
                  <?php
                  try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT * FROM tbl_products_a198548_pt2");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                  } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                  }
                  foreach($result as $productrow) {
                  ?>
                  <option value="<?php echo $productrow['FLD_PRODUCT_ID']; ?>">
                    <?php echo $productrow['FLD_BRAND']." ".$productrow['FLD_PRODUCT_NAME']; ?>
                  </option>
                  <?php } $conn = null; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="qty" class="col-sm-3 control-label">Quantity</label>
              <div class="col-sm-9">
                <input name="quantity" type="number" class="form-control" id="qty" min="1">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <input name="oid" type="hidden" value="<?php echo $readrow['FLD_ORDER_ID']; ?>">
                <button class="btn btn-success" type="submit" name="addproduct">
                  <span class="glyphicon glyphicon-plus"></span> Add Product
                </button>
                <button class="btn btn-warning" type="reset">
                  <span class="glyphicon glyphicon-erase"></span> Clear
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Order Products Table -->
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Products in This Order</div>
        <div class="panel-body">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Order Detail ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $stmt = $conn->prepare("
                SELECT 
                  tbl_orders_details_a198548_pt2.FLD_ORDER_DETAIL_ID,
                  tbl_orders_details_a198548_pt2.FLD_QUANTITY AS ORDERED_QUANTITY,
                  tbl_products_a198548_pt2.FLD_PRODUCT_NAME
                FROM tbl_orders_details_a198548_pt2
                JOIN tbl_products_a198548_pt2 
                  ON tbl_orders_details_a198548_pt2.FLD_PRODUCT_ID = tbl_products_a198548_pt2.FLD_PRODUCT_ID
                WHERE tbl_orders_details_a198548_pt2.FLD_ORDER_ID = :oid
              ");
              $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
              $oid = $_GET['oid'];
              $stmt->execute();
              $result = $stmt->fetchAll();
            } catch(PDOException $e) {
              echo "Error: " . $e->getMessage();
            }
            foreach($result as $detailrow) {
            ?>
            <tr>
              <td><?php echo $detailrow['FLD_ORDER_DETAIL_ID']; ?></td>
              <td><?php echo $detailrow['FLD_PRODUCT_NAME']; ?></td>
              <td><?php echo $detailrow['ORDERED_QUANTITY']; ?></td>
              <td>
                <a href="orders_details.php?delete=<?php echo $detailrow['FLD_ORDER_DETAIL_ID']; ?>&oid=<?php echo $_GET['oid']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete?');">
                  <span class="glyphicon glyphicon-trash"></span> Delete
                </a>
              </td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Invoice Button -->
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <a href="invoice.php?oid=<?php echo $_GET['oid']; ?>" target="_blank" class="btn btn-primary btn-lg btn-block">
        Generate Invoice
      </a>
    </div>
  </div>
  <br>
</div>

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">
function validateForm() {
  var x = document.getElementById("prd").value;
  var y = document.getElementById("qty").value;

  if (x == null || x == "") {
    alert("Product must be selected");
    document.getElementById("prd").focus();
    return false;
  }

  if (y == null || y == "") {
    alert("Quantity must be filled out");
    document.getElementById("qty").focus();
    return false;
  }

  return true;
}
</script>

</body>
</html>

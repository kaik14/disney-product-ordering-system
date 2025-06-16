<?php include_once 'database.php'; ?>

<?php
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("
    SELECT * FROM tbl_orders_a198548_pt2 o
    JOIN tbl_staffs_a198548_pt2 s ON o.FLD_STAFF_ID = s.FLD_STAFF_ID
    JOIN tbl_customers_a198548_pt2 c ON o.FLD_CUSTOMER_ID = c.FLD_CUSTOMER_ID
    WHERE o.FLD_ORDER_ID = :oid
  ");
  $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
  $oid = $_GET['oid'];
  $stmt->execute();
  $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
      padding: 30px;
    }
    .invoice-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }
    h1, h4 {
      font-weight: bold;
    }
    .table > thead > tr {
      background-color: #f0f0f0;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
      background-color: #fafafa;
    }
    .text-right {
      text-align: right;
    }
    .panel-default {
      border-radius: 8px;
    }
    .panel-heading {
      background-color: #337ab7 !important;
      color: white !important;
      border-radius: 6px 6px 0 0;
    }

    /*  隐藏打印按钮在打印时 */
    @media print {
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<body>

<div class="container invoice-box">
  <div class="row">
    <div class="col-xs-6">
      <img src="logo.png" width="60%">
    </div>
    <div class="col-xs-6 text-right">
      <!--  打印按钮区域 -->
      <div class="no-print" style="margin-bottom: 10px;">
        <button class="btn btn-primary" onclick="window.print()">
          <span class="glyphicon glyphicon-print"></span> Print
        </button>
      </div>
      <h1>INVOICE</h1>
      <h5>Order ID: <?php echo $readrow['FLD_ORDER_ID']; ?></h5>
      <h5>Date: <?php echo $readrow['FLD_ORDER_DATE']; ?></h5>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-xs-6">
      <div class="panel panel-default">
        <div class="panel-heading"><h4>From: My Bike Sdn. Bhd.</h4></div>
        <div class="panel-body">
          <p>
            Disney Products Sdn. Bhd. <br>
  Universiti Kebangsaan Malaysia (UKM) <br>
  43600 Bangi, Selangor, Malaysia <br>
          </p>
        </div>
      </div>
    </div>
    <div class="col-xs-6 text-right">
      <div class="panel panel-default">
        <div class="panel-heading"><h4>To: <?php echo $readrow['FLD_CUSTOMER_NAME']; ?></h4></div>
        <div class="panel-body">
          <p>
            Phone: <?php echo $readrow['FLD_CUSTOMER_PHONENUMBER']; ?><br>
            Savanna Executive Suites<br>
            Jalan Southville 2, Southville City<br>
            43800 Dengkil, Selangor
          </p>
        </div>
      </div>
    </div>
  </div>

<div class="panel panel-default">
  <div class="panel-heading"><h4>Ordered Products</h4></div>
  <div class="panel-body">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Product</th>
          <th class="text-right">Quantity</th>
          <th class="text-right">Unit Price (RM)</th>
          <th class="text-right">Total (RM)</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $grandtotal = 0;
        $counter = 1;
        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("
            SELECT p.FLD_PRODUCT_NAME, p.FLD_PRICE, d.FLD_QUANTITY AS ORDERED_QUANTITY
            FROM tbl_orders_details_a198548_pt2 d
            JOIN tbl_products_a198548_pt2 p ON d.FLD_PRODUCT_ID = p.FLD_PRODUCT_ID
            WHERE d.FLD_ORDER_ID = :oid
          ");
          $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
          $stmt->execute();
          $result = $stmt->fetchAll();
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }

        foreach ($result as $row) {
          $total = $row['FLD_PRICE'] * $row['ORDERED_QUANTITY'];
          $grandtotal += $total;
        ?>
        <tr>
          <td><?php echo $counter++; ?></td>
          <td><?php echo $row['FLD_PRODUCT_NAME']; ?></td>
          <td class="text-right"><?php echo $row['ORDERED_QUANTITY']; ?></td>
          <td class="text-right"><?php echo number_format($row['FLD_PRICE'], 2); ?></td>
          <td class="text-right"><?php echo number_format($total, 2); ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
          <td class="text-right"><strong><?php echo number_format($grandtotal, 2); ?></strong></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

  <div class="row">
    <div class="col-xs-6">
      <div class="panel panel-default">
        <div class="panel-heading"><h4>Bank Details</h4></div>
        <div class="panel-body">
          <p>Disney Products Sdn. Bhd. <br>
          Maybank Malaysia<br>
          SWIFT: MBBEMYKL<br>
          Account No: 123-456-789<br>
          IBAN: MY12 3456 7890 1234</p>
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="panel panel-default">
        <div class="panel-heading"><h4>Staff Contact</h4></div>
        <div class="panel-body">
          <p>Staff: <?php echo $readrow['FLD_STAFF_NAME']; ?><br>
          Phone: <?php echo $readrow['FLD_STAFF_PHONENUMBER']; ?><br>
          Position: <?php echo $readrow['FLD_POSITION']; ?></p>
          <p><em>This invoice is computer-generated. No signature required.</em></p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

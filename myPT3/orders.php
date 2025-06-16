<?php include_once 'orders_crud.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Disney Products Ordering System : Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 0px;
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

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Create New Order</h4>
        </div>
        <div class="panel-body">
          <form action="orders.php" method="post" class="form-horizontal">

            <div class="form-group">
              <label for="oid" class="col-sm-3 control-label">Order ID</label>
              <div class="col-sm-9">
                <input name="oid" type="text" class="form-control" readonly
                  value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_ORDER_ID']; ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="orderdate" class="col-sm-3 control-label">Order Date</label>
              <div class="col-sm-9">
                <input name="orderdate" type="text" class="form-control" readonly
                  value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_ORDER_DATE']; else echo date('Y-m-d'); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="sid" class="col-sm-3 control-label">Staff</label>
              <div class="col-sm-9">
                <select name="sid" class="form-control">
                  <?php
                  try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a198548_pt2");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                  } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                  }
                  foreach($result as $staffrow) {
                  ?>
                  <option value="<?php echo $staffrow['FLD_STAFF_ID']; ?>"
                    <?php if(isset($_GET['edit']) && $editrow['FLD_STAFF_ID'] == $staffrow['FLD_STAFF_ID']) echo "selected"; ?>>
                    <?php echo $staffrow['FLD_STAFF_NAME']; ?>
                  </option>
                  <?php } $conn = null; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="cid" class="col-sm-3 control-label">Customer</label>
              <div class="col-sm-9">
                <select name="cid" class="form-control">
                  <?php
                  try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT * FROM tbl_customers_a198548_pt2");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                  } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                  }
                  foreach($result as $custrow) {
                  ?>
                  <option value="<?php echo $custrow['FLD_CUSTOMER_ID']; ?>"
                    <?php if(isset($_GET['edit']) && $editrow['FLD_CUSTOMER_ID'] == $custrow['FLD_CUSTOMER_ID']) echo "selected"; ?>>
                    <?php echo $custrow['FLD_CUSTOMER_NAME']; ?>
                  </option>
                  <?php } $conn = null; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <?php if (isset($_GET['edit'])) { ?>
                  <button class="btn btn-primary" type="submit" name="update">
                    <span class="glyphicon glyphicon-pencil"></span> Update
                  </button>
                <?php } else { ?>
                  <button class="btn btn-success" type="submit" name="create">
                    <span class="glyphicon glyphicon-plus"></span> Create
                  </button>
                <?php } ?>
                <button class="btn btn-warning" type="reset">
                  <span class="glyphicon glyphicon-erase"></span> Clear
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Orders List</h4>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Staff</th>
                <th>Customer</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
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
            } catch(PDOException $e) {
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
                <a href="orders_details.php?oid=<?php echo $orderrow['FLD_ORDER_ID']; ?>" class="btn btn-info btn-xs">
                  <span class="glyphicon glyphicon-list"></span> Details
                </a>
                <a href="orders.php?edit=<?php echo $orderrow['FLD_ORDER_ID']; ?>" class="btn btn-success btn-xs">
                  <span class="glyphicon glyphicon-edit"></span> Edit
                </a>
                <a href="orders.php?delete=<?php echo $orderrow['FLD_ORDER_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs">
                  <span class="glyphicon glyphicon-trash"></span> Delete
                </a>
              </td>
            </tr>
            <?php } $conn = null; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

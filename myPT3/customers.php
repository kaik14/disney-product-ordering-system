<?php include_once 'customers_crud.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Disney Products Ordering System : Customers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
  body {
    background-color: #f9f9f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .panel {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    margin-bottom: 30px;
  }

  .panel-heading {
    background-color: #337ab7 !important;
    color: white !important;
    border-radius: 10px 10px 0 0;
    padding: 15px 20px;
    font-size: 18px;
    font-weight: bold;
  }

  .panel-body {
    padding: 20px;
  }

  .form-horizontal .control-label {
    text-align: left;
    font-weight: bold;
  }

  .btn {
    margin-right: 5px;
    border-radius: 4px;
  }

  .table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f7f7f7;
  }

  .table {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  }

  .page-header h2 {
    font-weight: bold;
    margin: 0;
  }

  .page-header {
    background-color: #337ab7;
    color: white;
    padding: 15px 20px;
    border-radius: 10px 10px 0 0;
    margin-top: 30px;
    margin-bottom: 0;
  }

  .pagination > li > a, 
  .pagination > li > span {
    border-radius: 4px;
  }

  .form-control {
    border-radius: 4px;
  }

  .form-group {
    margin-bottom: 15px;
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
          <h4>Create New Customer</h4>
        </div>
        <div class="panel-body">
          <form action="customers.php" method="post" class="form-horizontal">
            <div class="form-group">
              <label for="cid" class="col-sm-3 control-label">Customer ID</label>
              <div class="col-sm-9">
                <input name="cid" type="text" class="form-control" id="cid" placeholder="Customer ID"
                  value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_ID']; ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Name</label>
              <div class="col-sm-9">
                <input name="name" type="text" class="form-control" id="name" placeholder="Customer Name"
                  value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_NAME']; ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label for="phone" class="col-sm-3 control-label">Phone Number</label>
              <div class="col-sm-9">
                <input name="phone" type="text" class="form-control" id="phone" placeholder="Customer Phone Number"
                  value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_PHONENUMBER']; ?>" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <?php if (isset($_GET['edit'])) { ?>
                  <input type="hidden" name="oldcid" value="<?php echo $editrow['FLD_CUSTOMER_ID']; ?>">
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
          <h4>Customers List</h4>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT * FROM tbl_customers_a198548_pt2 ORDER BY FLD_CUSTOMER_ID ASC");
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
                  <a href="customers.php?edit=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>" class="btn btn-success btn-xs">
                    <span class="glyphicon glyphicon-edit"></span> Edit
                  </a>
                  <a href="customers.php?delete=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>"
                    onclick="return confirm('Are you sure to delete?');"
                    class="btn btn-danger btn-xs">
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

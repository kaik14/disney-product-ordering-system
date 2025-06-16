<?php 
  include_once 'staffs_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Disney Products Ordering System : Staffs</title>
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
    background-color: #337ab7 !important; /* 改成与按钮一致 */
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

      <!-- Create Form Panel -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Create New Staff</h4>
        </div>
        <div class="panel-body">
          <form action="staffs.php" method="post" class="form-horizontal">

            <!-- Staff ID -->
            <div class="form-group">
              <label for="sid" class="col-sm-3 control-label">Staff ID</label>
              <div class="col-sm-9">
                <input name="sid" type="text" class="form-control" placeholder="Staff ID" value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_STAFF_ID']; ?>" required>
              </div>
            </div>

            <!-- Name -->
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Name</label>
              <div class="col-sm-9">
                <input name="name" type="text" class="form-control" placeholder="Staff Name" value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_STAFF_NAME']; ?>" required>
              </div>
            </div>

            <!-- Position -->
            <div class="form-group">
              <label for="position" class="col-sm-3 control-label">Position</label>
              <div class="col-sm-9">
                <input name="position" type="text" class="form-control" placeholder="Position" value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_POSITION']; ?>" required>
              </div>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
              <label for="phone" class="col-sm-3 control-label">Phone Number</label>
              <div class="col-sm-9">
                <input name="phone" type="text" class="form-control" placeholder="Phone Number" value="<?php if (isset($_GET['edit'])) echo $editrow['FLD_STAFF_PHONENUMBER']; ?>" required>
              </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <?php if (isset($_GET['edit'])) { ?>
                  <input type="hidden" name="oldsid" value="<?php echo $editrow['FLD_STAFF_ID']; ?>">
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

      <!-- Staffs Table Panel -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Staffs List</h4>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Staff ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Phone Number</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a198548_pt2 ORDER BY FLD_STAFF_ID ASC");
  $stmt->execute();
  $result = $stmt->fetchAll();
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}


            foreach ($result as $readrow) {
            ?>
            <tr>
              <td><?php echo $readrow['FLD_STAFF_ID']; ?></td>
              <td><?php echo $readrow['FLD_STAFF_NAME']; ?></td>
              <td><?php echo $readrow['FLD_POSITION']; ?></td>
              <td><?php echo $readrow['FLD_STAFF_PHONENUMBER']; ?></td>
              <td>
                <a href="staffs.php?edit=<?php echo $readrow['FLD_STAFF_ID']; ?>" class="btn btn-success btn-xs">
                  <span class="glyphicon glyphicon-edit"></span> Edit
                </a>
                <a href="staffs.php?delete=<?php echo $readrow['FLD_STAFF_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs">
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

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

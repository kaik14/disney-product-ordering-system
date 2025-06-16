<?php
  include_once 'products_crud.php';
?>
 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Disney Products Ordering System : Products</title>
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
 
<div class="container">
  <div class="row">
    <div class="col-md-12 col-md-offset-0"> <!-- Wider column -->

      <!-- Create Form Panel -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Create New Product</h4>
        </div>
        <div class="panel-body">
          <form action="products.php" method="post" class="form-horizontal">
      
            <!-- Product ID -->
            <div class="form-group">
              <label for="pid" class="col-sm-3 control-label">ID</label>
              <div class="col-sm-9">
                <input name="pid" type="text" class="form-control" id="pid" placeholder="Product ID" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_ID']; ?>" required>
              </div>
            </div>

            <!-- Name -->
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Name</label>
              <div class="col-sm-9">
                <input name="name" type="text" class="form-control" id="name" placeholder="Product Name" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_NAME']; ?>" required>
              </div>
            </div>

            <!-- Price -->
            <div class="form-group">
              <label for="price" class="col-sm-3 control-label">Price</label>
              <div class="col-sm-9">
                <input name="price" type="text" class="form-control" id="price" placeholder="Product Price" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRICE']; ?>" min="0.0" step="0.01" required>
              </div>
            </div>

            <!-- Brand -->
            <div class="form-group">
              <label for="brand" class="col-sm-3 control-label">Brand</label>
              <div class="col-sm-9">
                <select name="brand" class="form-control" id="brand" required>
                  <option value="">Please select</option>
                  <option value="Disney" <?php if(isset($_GET['edit']) && $editrow['FLD_BRAND']=="Disney") echo "selected"; ?>>Disney</option>
                  <option value="Marvel" <?php if(isset($_GET['edit']) && $editrow['FLD_BRAND']=="Marvel") echo "selected"; ?>>Marvel</option>
                  <option value="Hasbro" <?php if(isset($_GET['edit']) && $editrow['FLD_BRAND']=="Hasbro") echo "selected"; ?>>Hasbro</option>
                  <option value="Disney Pixar" <?php if(isset($_GET['edit']) && $editrow['FLD_BRAND']=="Disney Pixar") echo "selected"; ?>>Disney Pixar</option>
                </select>
              </div>
            </div>

            <!-- Type -->
            <div class="form-group">
              <label for="type" class="col-sm-3 control-label">Type</label>
              <div class="col-sm-9">
                <select name="type" class="form-control" id="type" required>
                  <option value="">Please select</option>
                  <?php 
                    $types = ["Appliance","Backpack","Blanket","Car","Clock","Clothing","Doll","Figure","Figurine","Helmet","Jewelry","Keychain","Kitchenware","Lunchbox","Model","Mug","Playset","Puzzle","Replica","Snow Globe","Toy","Watch"];
                    foreach ($types as $type) {
                      echo "<option value=\"$type\"";
                      if (isset($_GET['edit']) && $editrow['FLD_TYPE'] == $type) echo " selected";
                      echo ">$type</option>";
                    }
                  ?>
                </select>
              </div>
            </div>  

            <!-- Quantity -->
            <div class="form-group">
              <label for="quantity" class="col-sm-3 control-label">Quantity</label>
              <div class="col-sm-9">
                <input name="quantity" type="text" class="form-control" id="quantity" placeholder="Product Quantity" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_QUANTITY']; ?>" min="0" required>
              </div>
            </div>  

            <!-- Description -->    
            <div class="form-group">
              <label for="description" class="col-sm-3 control-label">Description</label>
              <div class="col-sm-9">
                <input name="description" type="text" class="form-control" id="description" placeholder="Product Description" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_DESCRIPTION']; ?>" required>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <?php if (isset($_GET['edit'])) { ?>
                  <input type="hidden" name="oldpid" value="<?php echo $editrow['FLD_PRODUCT_ID']; ?>">
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

      <!-- Products Table Panel -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Products List</h4>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Brand</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Read
              $per_page = 6;
              if (isset($_GET["page"]))
                $page = $_GET["page"];
              else
                $page = 1;
              $start_from = ($page-1) * $per_page;

              try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("select * from tbl_products_a198548_pt2 LIMIT $start_from, $per_page");
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
                  <a href="products_details.php?pid=<?php echo $readrow['FLD_PRODUCT_ID']; ?>" class="btn btn-info btn-xs">
                    <span class="glyphicon glyphicon-list"></span> Details
                  </a>
                  <a href="products.php?edit=<?php echo $readrow['FLD_PRODUCT_ID']; ?>" class="btn btn-success btn-xs">
                    <span class="glyphicon glyphicon-edit"></span> Edit
                  </a>
                  <a href="products.php?delete=<?php echo $readrow['FLD_PRODUCT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs">
                    <span class="glyphicon glyphicon-trash"></span> Delete
                  </a>
                </td>
              </tr>
              <?php } $conn = null; ?>
            </tbody>
          </table>

          <nav>
            <ul class="pagination">
              <?php
              try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT * FROM tbl_products_a198548_pt2");
                $stmt->execute();
                $result = $stmt->fetchAll();
                $total_records = count($result);
              }
              catch(PDOException $e){
                echo "Error: " . $e->getMessage();
              }
              $total_pages = ceil($total_records / $per_page);
              ?>
              <?php if ($page==1) { ?>
                <li class="disabled"><span aria-hidden="true">«</span></li>
              <?php } else { ?>
                <li><a href="products.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
              <?php
              }
              for ($i=1; $i<=$total_pages; $i++)
                if ($i == $page)
                  echo "<li class=\"active\"><a href=\"products.php?page=$i\">$i</a></li>";
                else
                  echo "<li><a href=\"products.php?page=$i\">$i</a></li>";
              ?>
              <?php if ($page==$total_pages) { ?>
                <li class="disabled"><span aria-hidden="true">»</span></li>
              <?php } else { ?>
                <li><a href="products.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
              <?php } ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>

</body>
</html>
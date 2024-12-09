<?php
session_start();
include ('connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id))
{
    header("Location: index.php"); 
}
$id = $_GET['id'];
$fetch_query = mysqli_query($conn, "select * from tbl_vehicle where id='$id'");
$row = mysqli_fetch_array($fetch_query);
if(isset($_REQUEST['sv-vehicle']))
{
  $charge = $_POST['charge'];
  $status = $_POST['status'];

  $update_vehicle = mysqli_query($conn,"update tbl_vehicle set charge='$charge', status='$status', out_time=now() where id='$id'");


if($update_vehicle > 0)
{
?>
<script type="text/javascript">
    alert("Vehicle Updated successfully.");
    window.location.href='manage-vehicle.php';
</script>
<?php
}
}
?>
<?php include('include/header.php'); ?>
<div id="wrapper">
<?php include('include/side-bar.php'); ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Edit Vehicle</a>
          </li>
          
        </ol>
      <div class="card mb-3">
      <div class="card-header">
      <i class="fa fa-info-circle"></i>
            Edit Details</div> 
      <form method="post" class="form-valide">
      <div class="card-body">
      <div id="printThis">
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="name">Vehicle Category <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="category" id="category" class="form-control" placeholder="Enter Category" required value="<?php echo $row['category']; ?>" readonly>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="brand">Vehicle Brand Name <span class="text-danger">*</span></label>
      <div class="col-lg-6">
      <input type="text" name="brand" id="brand" class="form-control" placeholder="Enter Brand Name" required value="<?php echo $row['brand_name']; ?>" readonly>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="registration">Registration Number <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="regno" id="regno" class="form-control" placeholder="Enter Registration Number" required value="<?php echo $row['reg_no']; ?>" readonly>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="name">Vehicle Owner's Name <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="name" id="name" class="form-control" placeholder="Enter Owner's Name" required value="<?php echo $row['owner_name']; ?>" readonly>
       </div>
      </div> 
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="mobile">Owner's Mobile No. <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile No." required value="<?php echo $row['owner_mobile']; ?>" readonly>
       </div>
      </div>                     
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="intime">In Time <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="intime" id="intime" class="form-control" placeholder="In Time" required value="<?php echo $row['in_time']; ?>" readonly>
       </div>
      </div>     
    <?php
    if($row['status']==1){
    ?>
    <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="charge">Parking Charge <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="charge" id="charge" class="form-control" placeholder="Enter Parking Charge" required value="<?php echo $row['charge']; ?>">
       </div>
      </div> 
    <div class="form-group row">
    <label class="col-lg-4 col-form-label" for="status">Status <span class="text-danger">*</span>
    </label>
    <div class="col-lg-6">
    <select class="form-control" id="status" name="status" required>
    <option value="0">Out</option>
    </select>
    </div>
    </div>
  <?php } else{ ?>
    <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="charge">Parking Charge <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="charge" id="charge" class="form-control" placeholder="Enter Parking Charge" required value="<?php echo $row['charge']; ?>" readonly>
       </div>
      </div> 
    <div class="form-group row">
    <label class="col-lg-4 col-form-label" for="outtime">Out Time
    </label>
    <div class="col-lg-6">
    <input type="text" name="outtime" id="outtime" class="form-control" placeholder="Out Time" required value="<?php echo $row['out_time']; ?>" readonly>
    </div>
    </div>
  </div>
    <div class="form-group row">
    <div class="col-lg-8 ml-auto">
    <a href="javascript:void(0)" id="Printbtn" class="btn btn-success">Print</a>
    </div>
    </div>
  <?php } ?>
    <?php
    if($row['status']==1){
    ?>                                                
    <div class="form-group row">
    <div class="col-lg-8 ml-auto">
    <button type="submit" name="sv-vehicle" class="btn btn-primary">Save</button>
    </div>
    </div>
  <?php } ?>
    </div>
    </form>
  </div>
</div>
</div>   
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
 <?php include('include/footer.php'); ?>
 <style>
  @media screen{
  #printSection{
  display: none;
  }
}
@media print{
  body *{
  visibility: hidden;
  }
  #printSection, #printSection * {
  visibility: visible;
  }
  #printSection{
  position: absolute;
  left:0;
  top:0;
  width: 100%;
  }
}
</style>
<script>
  document.getElementById("Printbtn").onclick = function(){
    printElement(document.getElementById("printThis"));
  }

  function printElement(elem){
    var domClone = elem.cloneNode(true);
    var $printSection = document.getElementById("printSection");
    if(!$printSection){
      var $printSection = document.createElement("div");
      $printSection.id = "printSection";
      document.body.appendChild($printSection);
    }
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
  }
</script>
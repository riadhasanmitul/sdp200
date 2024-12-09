<?php
session_start();
include('connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if (empty($id)) {
    header("Location: index.php");
    exit(); // Add exit after redirection to stop further script execution
}
if (isset($_POST['sbt-vehicle'])) {
    $category = $_POST['category'];
    $brand_name = $_POST['brand'];
    $reg_no = $_POST['regno'];
    $owner_name = $_POST['name'];
    $owner_mobile = $_POST['mobile'];

    // Validation for mobile number
    if (!preg_match('/^01\d{9}$/', $owner_mobile)) {
        echo '<script type="text/javascript">alert("Please enter a valid 11-digit mobile number starting with 01.");</script>';
    } else {
        $insert_vehicle = mysqli_query($conn, "INSERT INTO tbl_vehicle SET category='$category', brand_name='$brand_name', reg_no='$reg_no', owner_name='$owner_name', owner_mobile='$owner_mobile', in_time=NOW()");

        if ($insert_vehicle) {
            echo '<script type="text/javascript">alert("Vehicle added successfully.");</script>';
        } else {
            echo '<script type="text/javascript">alert("Error adding vehicle. Please try again.");</script>';
        }
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
                    <a href="#">Add New Vehicle</a>
                </li>
            </ol>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    Submit Details</div>
                <form method="post" class="form-valide">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="category">Vehicle Category <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $select_category = mysqli_query($conn, "SELECT * FROM tbl_vehicle_category WHERE status=1");
                                    while ($cat = mysqli_fetch_array($select_category)) {
                                        ?>
                                        <option><?php echo $cat['category']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="brand">Vehicle Brand Name <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="brand" id="brand" class="form-control" placeholder="Enter Brand Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="registration">Registration Number <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="regno" id="regno" class="form-control" placeholder="Enter Registration Number" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="name">Vehicle Owner's Name <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Owner's Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="mobile">Owner's Mobile No. <span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile No." required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="submit" name="sbt-vehicle" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<?php include('include/footer.php'); ?>

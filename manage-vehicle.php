<?php
session_start();
include ('connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if (empty($id)) {
    header("Location: index.php");
    exit();
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
                    <a href="#">Manage Vehicle</a>
                </li>
            </ol>

            <form method="post">
                <div class="form-group row" style="padding: 20px;">
                    <label class="col-lg-0 col-form-label-report" for="from">From</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" id="from_date" name="from_date" placeholder="Select Date" required>
                    </div>

                    <label class="col-lg-0 col-form-label" for="from">To</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" id="to_date" name="to_date" placeholder="Select Date" required>
                    </div>

                    <div class="col-lg-3">
                        <select class="form-control" id="category" name="category">
                            <option value="">Select Category</option>
                            <?php 
                            $fetch_category = mysqli_query($conn, "SELECT * FROM tbl_vehicle_category");
                            while ($row = mysqli_fetch_array($fetch_category)) {
                            ?>
                            <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <button type="submit" name="srh-btn" class="btn btn-primary search-button">Search</button>
                    </div>
                </div>
            </form>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i> View Details
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Category</th>
                                    <th>Brand Name</th>
                                    <th>Registration No</th>
                                    <th>Owner's Mobile</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['srh-btn'])) {
                                    $from_date = date('Y-m-d', strtotime($_POST['from_date']));
                                    $to_date = date('Y-m-d', strtotime($_POST['to_date']));
                                    $cat = $_POST['category'];
                                    $search_query = mysqli_query($conn, "SELECT * FROM tbl_vehicle WHERE category='$cat' AND DATE(in_time) BETWEEN '$from_date' AND '$to_date'");
                                } else {
                                    if (isset($_GET['ids'])) {
                                        $id = $_GET['ids'];
                                        mysqli_query($conn, "DELETE FROM tbl_vehicle WHERE id='$id'");
                                    }
                                    $search_query = mysqli_query($conn, "SELECT * FROM tbl_vehicle");
                                }

                                $sn = 1;
                                while ($row = mysqli_fetch_array($search_query)) {
                                ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['brand_name']; ?></td>
                                    <td><?php echo $row['reg_no']; ?></td>
                                    <td><?php echo $row['owner_mobile']; ?></td>
                                    <td>
                                        <?php echo $row['status'] == 1 ? '<span class="badge badge-success">In</span>' : '<span class="badge badge-danger">Out</span>'; ?>
                                    </td>
                                    <td>
                                        <a href="edit-vehicle.php?id=<?php echo $row['id']; ?>">
                                            <?php if ($row['status'] == 1) { ?>
                                                <i class="fa fa-pencil m-r-5"></i> Edit&nbsp;&nbsp;
                                            <?php } else { ?>
                                                <i class="fa fa-eye m-r-5"></i> View
                                            <?php } ?>
                                        </a>
                                        <a href="manage-vehicle.php?ids=<?php echo $row['id']; ?>" onclick="return confirmDelete()">
                                            <i class="fa fa-trash-o m-r-5"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php $sn++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php include('include/footer.php'); ?>

<script language="JavaScript" type="text/javascript">
function confirmDelete() {
    return confirm('Are you sure you want to delete this Vehicle Details?');
}
</script>

<?php
session_start();
include 'connection.php';
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id))
{
    header("Location: index.php"); 
}

 $total_vehicle = mysqli_query($conn,"select count(*) from tbl_vehicle");
 $total_vehicle = mysqli_fetch_row($total_vehicle);

 $today_vehicle = mysqli_query($conn,"select COUNT(*) from tbl_vehicle where DATE(in_time) = CURDATE();");
 $today_vehicle = mysqli_fetch_row($today_vehicle);

 $today_vehicle_out = mysqli_query($conn,"select COUNT(*) from tbl_vehicle where DATE(in_time) = CURDATE() and status=0");
 $today_vehicle_out = mysqli_fetch_row($today_vehicle_out);

 $yesterday_vehicle = mysqli_query($conn,"select count(*) from tbl_vehicle where DATE(in_time)=CURDATE()-1");
 $yesterday_vehicle = mysqli_fetch_row($yesterday_vehicle);

 $week_vehicle = mysqli_query($conn,"select count(*) from tbl_vehicle where DATE(in_time)>= CURDATE()-7");
 $week_vehicle = mysqli_fetch_row($week_vehicle);

?>
<?php include('include/header.php'); ?>

  <div id="wrapper">

    <?php include('include/side-bar.php'); ?>

    <div id="content-wrapper">

      <div class="container-fluid">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
        </ol>
<div class="row">
  <div class="col-sm-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
              <i class="fa fa-car"></i>
            </div>
          </div>
          <div class="widget-summary-col">
            <div class="summary">
              <h4 class="title">Total Vehicle Parked</h4>
              <div class="info">
                <strong class="amount"><?php echo $total_vehicle[0]; ?></strong><br>   
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-sm-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
              <i class="fa fa-car"></i>
            </div>
          </div>
          <div class="widget-summary-col">
            <div class="summary">
              <h4 class="title">Today Vehicle Parked</h4>
              <div class="info">
                <strong class="amount"><?php echo $today_vehicle[0]; ?></strong><br>  
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-sm-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
              <i class="fa fa-car"></i>
            </div>
          </div>
          <div class="widget-summary-col">
            <div class="summary">
              <h4 class="title">Today Vehicle Out</h4>
              <div class="info">
                <strong class="amount"><?php echo $today_vehicle_out[0]; ?></strong><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-sm-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
              <i class="fa fa-car"></i>
            </div>
          </div>
          <div class="widget-summary-col">
            <div class="summary">
              <h4 class="title">Yesterday Vehicle Parked</h4>
              <div class="info">
                <strong class="amount"><?php echo $yesterday_vehicle[0]; ?></strong><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-sm-4">
    <section class="panel panel-featured-left panel-featured-primary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
              <i class="fa fa-car"></i>
            </div>
          </div>
          <div class="widget-summary-col">
            <div class="summary">
              <h4 class="title">Last 7 Days Vehicle Parked</h4>
              <div class="info">
                <strong class="amount"><?php echo $week_vehicle[0]; ?></strong><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
</div>
</div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <?php include('include/footer.php'); ?>

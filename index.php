<?php
session_start();
include 'connection.php';

if(isset($_REQUEST['login_btn'])) {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    
    $select_query = mysqli_query($conn, "SELECT id, user_name, role FROM tbl_users WHERE emailid='$email' AND password='$pwd'");
    $rows = mysqli_num_rows($select_query);

    if($rows > 0) {
        $user = mysqli_fetch_assoc($select_query);
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['user_name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'super_admin') {
            header("Location: super_admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
    } else {
        echo "<script>alert('You have entered wrong emailid or password.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Parking Management System</title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="css/custom_style.css?ver=1.1" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
</head>
<body style="background-image: url('https://www.premiumcarparks.co.uk/themes/hambern-hambern-blank-bootstrap-4/assets/img/PCPPhoto3sizedforWeb.jpg') !important; background-size: cover;
    background-position: center; " class=" main-bg">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
    <div class="container">
    <div style="margin-top: 200px !important;" class="card card-login mx-auto mt-5">
      <div class="card-header">
       <h2><center>Parking Management System (PMS)</center></h2>
      </div>
      <div class="card-body">
        <form name="login"  method="post" action="">
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required="required" autofocus="autofocus">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pwd" required="required">
              <label for="inputPassword">Password</label>
            </div>
          </div>
          <input type="submit" class="btn btn-success btn-block" name="login_btn" value="Login">
        </form>
        <br>
        <a href="user_dashboard.php">Track user current vehicle</a>
      </div>
    </div>
  </div>
    </div>
</body>
</html>

<?php 
  require_once '../database/database.php';

  if(!$user->is_LoggedIn())
  {
    $user->Redirect('login');
  }
  $getUser = $_SESSION['username'];

  if($user->FetchAllDrivers())
  {
      $getAllDriver = $user->fetchAllDrivers;
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DELMOVER ADMIN PANEL</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $getUser; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $getUser; ?>
                  <small>Administrator</small>
                </p>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="../model/logout.php?logout=true" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $getUser; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="admin">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="active">
          <a href="drivers">
            <i class="fa fa-id-card"></i> <span>Drivers</span>
          </a>
        </li>
        <li>
          <a href="topuprequest">
            <i class="fa fa-money"></i> <span>Top Up Request</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-files-o"></i> <span>Requirements</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Drivers
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Driver Applicants</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Address</th>
                  <th>Phone Number</th>
                  <th>Email Address</th>
                  <th>Image</th>
                  <th>NBI</th>
                  <th>License</th>
                  <th>OR/CR</th>
                  <th>Image Vehicle Front</th>
                  <th>Image Vehicle Back</th>
                  <th>Vehicle Model</th>
                  <th>Plate Number</th>
                  <th>Training Date</th>
                  <th>Confirm Account</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                  foreach($getAllDriver as $data)
                  {
                    echo '<tr>';
                    echo '<td>'.$data['fullname'].'</td>';
                    echo '<td>'.$data['address'].'</td>';
                    echo '<td>'.$data['phonenumber'].'</td>';
                    echo '<td>'.$data['emailaddress'].'</td>';
                    echo '<td><a href="'.str_replace("192.168.254.123/delmover/admin/","",$data['image']).'"><img src="'.str_replace("192.168.254.123/delmover/admin/","",$data['image']).'" class="img-responsive" style="width:100px;height:70px;"</a></td>';
                    echo '<td><a href="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_nbi']).'"><img src="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_nbi']).'" class="img-responsive" style="width:100px;height:70px;"</a></td>';
                    echo '<td><a href="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_license']).'"><img src="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_license']).'" class="img-responsive" style="width:100px;height:70px;"</a></td>';
                    echo '<td><a href="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_or_cr']).'"><img src="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_or_cr']).'" class="img-responsive" style="width:100px;height:70px;"</a></td>';
                    echo '<td><a href="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_front']).'"><img src="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_front']).'" class="img-responsive" style="width:100px;height:70px;"</a></td>';
                    echo '<td><a href="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_back']).'"><img src="'.str_replace("192.168.254.123/delmover/admin/","",$data['image_back']).'" class="img-responsive" style="width:100px;height:70px;"</a></td>';
                    echo '<td>'.$data['vehicle_model'].'</td>';
                    echo '<td>'.$data['plate_number'].'</td>';
                    echo '<td>'.$data['training_date'].'</td>';
					if($data['account_activated'] == 0)
					{
						echo '<td>';
						echo '<div class="row">';
						echo '<div class="col-md-6">';
						echo '<a href="../model/admin_confirm.php?id='.$data['id'].'" class="btn btn-success btn-circle"><i class="fa  fa-check-circle"></i></a>';
						echo '</div>';
						echo '<div class="col-md-6">';
						echo '<a href="../model/admin_decline.php?id='.$data['id'].'" class="btn btn-danger btn-circle"><i class="fa  fa-trash"></i></a>';
						echo '</div>';
						echo '</div>';
					}
					else
					{
						echo '<td>Approved</td>';
					}
					echo '</tr>';
                  }
                  ?>
                </tbody>
               <!--  <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot> -->
              </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2020-<span id="date"></span> <a href="#">DELMOVER</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../bower_components/raphael/raphael.min.js"></script>
<script src="../bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../bower_components/moment/min/moment.min.js"></script>
<script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- GET DATE FOR FOOTER-->
      <script type="text/javascript">
        n = new Date();
        y = n.getFullYear();
        document.getElementById("date").innerHTML = y;

        $(function () {
        $('#example1').DataTable()
      })
      </script>
</body>
</html>

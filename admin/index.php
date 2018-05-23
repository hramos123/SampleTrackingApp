<?php 
include('config/global.php');
ob_start();
session_start();
if($_SESSION['adminuser']=="")
{
    header("location:login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Admin Panel:". $Global['baseurl'];?></title>
<link rel="stylesheet" href="css/admin_style.css" type="text/css" />
</head>

<body>
<div class="main_cont">
	<?php include('includes/admin_header.php');?>
		<div class="admin_area">
			<?php include('includes/admin_menubar.php');?>
			<div class="admin_module_area">
				<div class="admin_title"><div class="admin_title_img"><img src="images/icon_user.gif" style="height:30px; vertical-align:middle;" /></div><div class="admin_title_text">Welcome User</div></div><!--admin_title ends-->
				<div class="dashboard_icons_cont">
					<div class="dashboard_icon" onclick="window.location='list_experiment.php'">
						<div class="dash_icon" style="background:url(images/experiment.png) no-repeat;"></div>
						<div class="dash_name">Experiments</div>
					</div>
					<div class="dashboard_icon" onclick="window.location='list_project.php'">
						<div class="dash_icon" style="background:url(images/project.png) no-repeat;"></div>
						<div class="dash_name">Projects</div>
					</div>
					<div class="dashboard_icon" onclick="window.location='list_user.php'">
						<div class="dash_icon" style="background:url(images/users.png) no-repeat;"></div>
						<div class="dash_name">Users</div>
					</div>
					<div class="dashboard_icon" onclick="window.location='list_assays.php'">
						<div class="dash_icon" style="background:url(images/project.png) no-repeat;"></div>
						<div class="dash_name">Assays</div>
					</div>
					<div class="dashboard_icon" onclick="window.location='list_sample_characterizations.php'">
						<div class="dash_icon" style="background:url(images/poll.gif) no-repeat;"></div>
						<div class="dash_name">Sample Characterizations</div>
					</div>
					<div class="dashboard_icon" onclick="window.location='list_sampleset.php'">
						<div class="dash_icon" style="background:url(images/project.png) no-repeat;"></div>
						<div class="dash_name">Sample Sets</div>
					</div>
				</div><!--dashboard_icons_cont ends-->
			</div><!--admin_module_area ends-->
		</div><!--admin_area ends-->
	<?php include('includes/admin_footer.php');?>
</div><!--main_cont ends-->
</body>
</html>
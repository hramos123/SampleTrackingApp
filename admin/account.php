<?php 
include('config/global.php');
ob_start();
session_start();
if($_SESSION['adminuser']=="") 
	{
		header("location:login.php");
	}
	
if(isset($_POST['update'])){
$user = $_POST['username'];
$pass = base64_encode($_POST['password']);
$sql = "UPDATE `staff_list` SET `username`='$user',`password`='$pass' WHERE `role`='1' and `id`=$_SESSION[adminuser]";
if(@mysql_query($sql))
	{
		header("location:account.php?msg=ais");
	}
	else
	{
		header("location:account.php?msg=aif");
	}
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
				<div class="admin_title"><div class="admin_title_img"><img src="images/icon_setting.gif" style="height:30px; vertical-align:middle;" /></div><div class="admin_title_text">Account Settings</div></div><!--admin_title ends-->
				<form method="post" enctype="multipart/form-data">
				<table>
					<?php if($_GET['msg']=='aif'){?>
					<tr>
						<td colspan="2" style="color:#ff0000; font-size:14px; vertical-align:middle;" valign="top"><img src="images/b_drop.png" alt="wrong" /> Can't Update Information!</td>
					</tr>
					<?php } if($_GET['msg']=='ais'){ ?>
					<tr>
						<td colspan="2" style="color:#0e8f38; font-size:14px; vertical-align:middle;" valign="top"><img src="images/correct.gif" alt="correct" /> Information Updated Succesfully</td>
					</tr>
					<?php } ?>
					<?php
					$setting_query = mysql_query("SELECT * FROM `staff_list` WHERE `id`='$_SESSION[adminuser]' and `role`='1'");
					$setting = mysql_fetch_array($setting_query);
					?>
					<tr>
						<td class="tdhead">Username:</td><td><input type="text" name="username" value="<?php echo $setting['username'];?>" /> </td>
						
					</tr>
					<tr>
						<td class="tdhead">Password:</td><td><input type="password" name="password" value="<?php echo $setting['password'];?>" /> </td>
					</tr>
					<tr>
						<td class="tdhead"></td><td><input type="submit" name="update" value="Update" class="btn" /> </td>
					</tr>
				</table>
				</form>
			</div>
		</div><!--admin_area ends-->
	<?php include('includes/admin_footer.php');?>
</div><!--main_cont ends-->
</body>
</html>
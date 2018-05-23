<?php 
include('config/global.php');
ob_start();
session_start();
if(isset($_REQUEST['ilogout']))
{
	$_SESSION['adminuser']= "";
	session_unset();
	session_destroy();
	
}
if(isset($_POST['login']))
{
	$user = $_POST['username'];
	$pass = base64_encode($_POST['password']);
	//$admin_query=mysql_query("SELECT * FROM `admin` WHERE `role`='0'");
	$admin_query = mysql_query("SELECT * FROM `staff_list` WHERE `username`='$user' and `password`='$pass' and `role`='1'");
	$user_detail = mysql_fetch_array($admin_query);
	$count = mysql_num_rows($admin_query);
	if($count > 0)
	{
		 //echo '<script>alert("'.$user_detail['id'].'")</script>';
		$_SESSION['adminuser'] = $user_detail['id'];
		header("Location:index.php");
	}
	else
	{
		header("Location:login.php?msg=no");
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
			
			<div class="admin_module_area">
				<div class="admin_title"><div class="admin_title_text">Login Here</div></div><!--admin_title ends-->
				<div class="login_box">
					<table border="0" cellspacing="1" cellpadding="4">
						<form method="post">
						<tr>
							<td>Username:</td><td><input type="text" name="username" /></td>
						</tr>
						<tr>
							<td>Password:</td><td><input type="password" name="password" /></td>
						</tr>
						<tr>
							<td></td><td><input type="submit" value="Login" name="login" class="btn" />&nbsp; <input type="reset" class="btn" /></td>
						</tr>
						<tr>
							<td></td><td><a href="#">forgot password?</a></td>
						</tr>
						</form>
					</table>
				</div><!--login_box ends-->
			</div>
		</div><!--admin_area ends-->
	<?php include('includes/admin_footer.php');?>
</div><!--main_cont ends-->
</body>
</html>
<?php 
include('config/global.php');
ob_start();
session_start();
if($_SESSION['adminuser']=="") 
	{
		header("location:login.php");
	}
	
if(isset($_POST['save']))
{	
	$title = $_POST['title'];
	$description = $_POST['description'];
	
	//$date_added = date('d M Y h:i A');
	
	$sql="INSERT INTO `sample_characterizations` values('','$title', '$description')";
	if(@mysql_query($sql))
	{
		header("location:add_sample_characterization.php?msg=ais");
	}
	else
	{
		header("location:add_sample_characterization.php?msg=aif");
	}
}

if(isset($_POST['update']))
{	
	$title = $_POST['title'];
	$description = $_POST['description'];
	
		
	$sql="UPDATE `sample_characterizations` SET `name`='$title', description='$description' WHERE `id`='$_REQUEST[id]'";
	if(@mysql_query($sql))
	{
		header("location:add_sample_characterization.php?msg=ais&id=$_REQUEST[id]");
	}
	else
	{
		header("location:add_sample_characterization.php?msg=aif&id=$_REQUEST[id]");
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
				<div class="admin_title"><div class="admin_title_img"><img src="images/icon_content.gif" style="height:30px; vertical-align:middle;" /></div>
				<div class="admin_title_text">Add Sample Characterization</div></div><!--admin_title ends-->
				<table width="800">
					<?php @$fetch = mysql_fetch_array(mysql_query("SELECT * FROM `sample_characterizations` WHERE `id`='$_REQUEST[id]'"));?>
					<form method="post">
					<?php if($_GET['msg']=='aif'){?>
					<tr>
						<td colspan="2" style="color:#ff0000; font-size:14px; vertical-align:middle;" valign="top"><img src="images/b_drop.png" alt="wrong" /> Can't Update Information!</td>
					</tr>
					<?php } if($_GET['msg']=='ais'){ ?>
					<tr>
						<td colspan="2" style="color:#0e8f38; font-size:14px; vertical-align:middle;" valign="top"><img src="images/correct.gif" alt="correct" /> Information Updated Succesfully</td>
					</tr>
					<?php } ?>
					<tr>
						<td class="tdhead">Name:</td><td><input type="text" name="title" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Description:</td><td><input type="text" name="description" class="widthtext" value="<?php echo $fetch['description'];?>" /></td>
					</tr>
						
					
					<tr>
						<td></td>
						<?php if(isset($_REQUEST['id'])){?>
						<td><input type="submit" name="update" value="Update" class="btn" /></td>
						<?php } else { ?>
						<td><input type="submit" name="save" value="Save" class="btn" /></td>
						<?php } ?>
					</tr>
					</form>
				</table>
				
			</div><!--admin_module_area ends-->
		</div><!--admin_area ends-->
	<?php include('includes/admin_footer.php');?>
</div><!--main_cont ends-->
</body>
</html>
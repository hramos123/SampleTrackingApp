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
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$role = $_POST['role'];
	$username = $_POST['username'];
	$password = base64_encode($_POST['password']);
	$email = $_POST['email'];
	$title = $_POST['title'];
	$department = $_POST['department'];
	$mailing_list = $_POST['mailing_list'];
	//$date_added = date('d M Y h:i A');
	
	$sql="INSERT INTO `staff_list` values('','$username','$password','$role','$first_name','$last_name','$email','$title','$department','$mailing_list')";
	if(@mysql_query($sql))
	{
		header("location:add_user.php?msg=ais");
	}
	else
	{
		header("location:add_user.php?msg=aif");
	}
}

if(isset($_POST['update']))
{	
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$role = $_POST['role'];
	$username = $_POST['username'];
	$password = base64_encode($_POST['password']);
	$email = $_POST['email'];
	$title = $_POST['title'];
	$department = $_POST['department'];
	$mailing_list = $_POST['mailing_list'];
		
	$sql="UPDATE `staff_list` SET `username`='$username',`password`='$password',`role`='$role',`first_name`='$first_name',`last_name`='$last_name',`email`='$email',`title`='$title',`department`='$department',`mailing_list_id`='$mailing_list' WHERE `id`='$_REQUEST[id]'";
	if(@mysql_query($sql))
	{
		header("location:add_user.php?msg=ais&id=$_REQUEST[id]");
	}
	else
	{
		header("location:add_users.php?msg=aif&id=$_REQUEST[id]");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Admin Panel:". $Global['baseurl'];?></title>
<link rel="stylesheet" href="css/admin_style.css" type="text/css" />
<!--<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>-->
<script type="text/javascript">


window.onload = function() 
{
   var eSelect = document.getElementById('role');
   var username = document.getElementById('username');
	var password = document.getElementById('password');
   eSelect.onchange = function() {
         if(eSelect.selectedIndex == 1) {
            username.style.display = 'block';
				password.style.display = 'block';
            } else {
                username.style.display = 'none';
					password.style.display = 'none';
            }
        }
    }
</script>
<style>
#username, #password{display:none;}
</style>
</head>

<body>
<div class="main_cont">
	<?php include('includes/admin_header.php');?>
		<div class="admin_area">
			<?php include('includes/admin_menubar.php');?>
			<div class="admin_module_area">
				<div class="admin_title"><div class="admin_title_img"><img src="images/icon_content.gif" style="height:30px; vertical-align:middle;" /></div><div class="admin_title_text">Add User</div></div><!--admin_title ends-->
				<table width="800">
					<?php @$fetch = mysql_fetch_array(mysql_query("SELECT * FROM `staff_list` WHERE `id`='$_REQUEST[id]'"));?>
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
						<td class="tdhead">First Name:</td><td><input type="text" name="first_name" class="widthtext" value="<?php echo $fetch['first_name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Last Name:</td><td><input type="text" name="last_name" class="widthtext" value="<?php echo $fetch['last_name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead" >Role:</td>
						<td>
							<select name="role" id="role">
								<option value="0" <?php if($fetch['role']=='0'){ ?> selected="selected"<?php } ?>>Website User</option>
								<option value="1" <?php if($fetch['role']=='1'){ ?> selected="selected"<?php } ?>>Administrator</option>
							</select>
						</td>
					</tr>
					<tr id="username" <?php if($fetch['role']=='1'){ ?> style="display:block;"<?php } ?>>
						<td class="tdhead">Username:</td><td> <input type="text" name="username" value="<?php echo $fetch['username'];?>" /></td>
					</tr>
					<tr id="password" <?php if($fetch['role']=='1'){ ?> style="display:block;"<?php } ?>>
						<td class="tdhead">Password:</td><td> <input type="text" name="password" value="<?php echo base64_decode($fetch['password']);?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Email:</td><td><input type="email" name="email" value="<?php echo $fetch['email'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Title:</td>
						<td>
							<select name="title">
								<option value="Supervisor" <?php if($fetch['title']=='Supervisor'){?> selected="selected"<?php } ?>>Supervisor</option>
								<option value="Analyst" <?php if($fetch['title']=='Analyst'){?> selected="selected"<?php } ?>>Analyst</option>
								<option value="Reviewer" <?php if($fetch['title']=='Reviwer'){?> selected="selected"<?php } ?>>Reviewer</option>
								<option value="Collaborator" <?php if($fetch['title']=='Collaborator'){?> selected="selected"<?php } ?>>Collaborator</option>
								<option value="Director" <?php if($fetch['title']=='Director'){?> selected="selected"<?php } ?>>Director</option>
							</select>
							
						</td>
					</tr>
					<tr>
						<td class="tdhead">Department:</td>
						<td>
							<select name="department">
								<option value="610" <?php if($fetch['department']=='610'){?>selected="selected"<?php } ?>>610</option>
								<option value="620" <?php if($fetch['department']=='620'){?>selected="selected"<?php } ?>>620</option>
								<option value="625" <?php if($fetch['department']=='625'){?>selected="selected"<?php } ?>>625</option>
								<option value="630" <?php if($fetch['department']=='630'){?>selected="selected"<?php } ?>>630</option>
							</select>
							
						</td>
					</tr>
					<tr>
						<td class="tdhead">Mailing List Group:</td>
                        <td><select name="mailing_list">
                        		<? $mlids = mysql_query("select * from mailing_lists order by name asc") or die(mysql_error());
									while($mlid = mysql_fetch_assoc($mlids)){ ?>
                                 <option value="<? echo $mlid['id'] . "\" "; if ($mlid['id'] == $fetch['mailing_list_id']){echo "selected";} ?>><?= $mlid['name'] ?></option>
                                 <? } ?>
                                 </select>
                                 </td>
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
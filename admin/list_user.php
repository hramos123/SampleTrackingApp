<?php 
include('config/global.php');
ob_start();
session_start();
if($_SESSION['adminuser']=="")
	{
		header("location:login.php");
	}
	

if(isset($_REQUEST['delid']))
{
	$edit_query="DELETE FROM `staff_list` WHERE `id`='$_REQUEST[delid]'";
	if(@mysql_query($edit_query))
	{
		header("location:list_user.php?msg=ais");
	}
	else
	{
		header("location:list_user.php?msg=aif");
	}
}


?>
<?php
@$checkbox = $_POST['checkbox']; //from name="checkbox[]"
@$countCheck = count($_POST['checkbox']);
if(isset($_POST['delete'])){
for($i=0;$i<$countCheck;$i++){
$del_id = $checkbox[$i];
$sql = "DELETE FROM `staff_list` WHERE id='$del_id'";
mysql_query($sql); 
}
header("location:list_user.php?msg=ais");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Admin Panel:". $Global['baseurl'];?></title>
<link rel="stylesheet" href="css/admin_style.css" type="text/css" />
<script language="javascript">
//check all and uncheck all function by honeyonsys
function toggleCheckboxes(flag) {    
    var form = document.getElementById('checkbox_form');
    var inputs = form.elements;
    if(!inputs){
        //console.log("no inputs found");
        return;
    }
    if(!inputs.length){
        //console.log("only one elements, forcing into an array");
        inputs = new Array(inputs);        
    }

    for (var i = 0; i < inputs.length; i++) {  
      //console.log("checking input");
      if (inputs[i].type == "checkbox") {  
        inputs[i].checked = flag;
      }  
    }  
}
</script>
</head>

<body>
<div class="main_cont">
	<?php include('includes/admin_header.php');?>
		<div class="admin_area">
			<?php include('includes/admin_menubar.php');?>
			<div class="admin_module_area">
				<div class="admin_title"><div class="admin_title_img"><img src="images/icon_content.gif" style="height:30px; vertical-align:middle;" /></div><div class="admin_title_text">Project List</div></div><!--admin_title ends-->
				<form method="post" enctype="multipart/form-data" id="checkbox_form">
				<table width="800">
					<tr>
						<td colspan="6">
						<input type="button" name="CheckAll" value="Check All" onclick="toggleCheckboxes(true)">
						<input type="button" name="UnCheckAll" value="Uncheck All" onclick="toggleCheckboxes(false)">
						<input type="submit" value="Delete Selected" name="delete" id="delete" onclick="return confirm('are you sure want to delete this news!');  document.getElementById('delete').type='submit'" />
						</td>
					</tr>
					<tr>
						<th width="4%"><input type="checkbox" onselect="toggleCheckboxes(true)" /></th>
						<th width="5%">ID</th>
						<th width="53%">User Name</th>
						
						<th width="20%">Email</th>
						<th width="8%">title</th>
						<th width="10%">Action</th>
					</tr>
					<?php
					
					$list_query = mysql_query("SELECT * FROM `staff_list` ORDER BY `id` DESC");
					while($list = mysql_fetch_array($list_query)){
					?>
					<tr>
						<td><input type="checkbox" name="checkbox[]" id="checkbox[]" value="<?php echo $list['id']; ?>" /></td>
						<td><?php echo $list['id'];?></td>
						
						<td><?php echo $list['first_name']." ".$list['last_name'];?></td>
						
						<td><?php echo $list['email'];?></td>
						
						<td><?php echo $list['title'];?></td>
						
						<td>&nbsp;&nbsp;<img src="images/b_edit.png" title="edit" style="cursor:pointer;" onclick="window.location='add_user.php?id=<?php echo $list['id'];?>'" />&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="list_user.php?delid=<?php echo $list['id'];?>"><img src="images/b_drop.png" title="Delete" style="cursor:pointer;" onclick="return confirm('are you sure want to delete this comment!');" /></a></td>
					</tr>
					<?php } ?>
				</table>
				</form>
			</div><!--admin_module_area ends-->
		</div><!--admin_area ends-->
	<?php include('includes/admin_footer.php');?>
</div><!--main_cont ends-->
</body>
</html>
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
	$experiment = $_POST['experiment'];
	$submission_date = $_POST['submission_date'];
	$expected_completion_date = $_POST['expected_completion_date'];
	$submitted_by = $_POST['submitted_by'];
	$submitted_to = $_POST['submitted_to'];
	$analyzed_by = $_POST['analyzed_by'];
	$reviewed_by = $_POST['reviewed_by'];
	$storage_temp = $_POST['storage_temp'];
	$theorized_concentration = $_POST['theorized_concentration'];
	$result_type = $_POST['result_type'];
	$require_raw_data = $_POST['require_raw_data'];
	$provide_spent_media = $_POST['provide_spent_media'];
	$information_sought = $_POST['information_sought'];
	$result_format = $_POST['result_format'];
	$result_location = $_POST['result_location'];
	$status = $_POST['status'];
	$comment = $_POST['comment'];
	$matrix_comment = $_POST['matrix_comment'];
	$date_analyzed = $_POST['date_analyzed'];
	$date_reviewed = $_POST['date_reviewed'];
	
	
	
	//$date_added = date('d M Y h:i A');
	
	$sql="INSERT INTO `samplesets` values('','$experiment','$submission_date','$expected_completion_date','$submitted_by','$submitted_to','$analyzed_by','$reviewed_by','$storage_temp','$theorized_concentration','$result_type','$require_raw_data','$provide_spent_media','$information_sought','$result_format','$result_location','$status','$comment','$matrix_comment','$date_analyzed','$date_reviewed')";
	if(@mysql_query($sql))
	{
		header("location:add_sampleset.php?ais");
	}
	else
	{
		header("location:add_sampleset.php?aif");
	}
}

if(isset($_POST['update']))
{	
	$experiment = $_POST['experiment'];
	$submission_date = $_POST['submission_date'];
	$expected_completion_date = $_POST['expected_completion_date'];
	$submitted_by = $_POST['submitted_by'];
	$submitted_to = $_POST['submitted_to'];
	$analyzed_by = $_POST['analyzed_by'];
	$reviewed_by = $_POST['reviewed_by'];
	$storage_temp = $_POST['storage_temp'];
	$theorized_concentration = $_POST['theorized_concentration'];
	$result_type = $_POST['result_type'];
	$require_raw_data = $_POST['require_raw_data'];
	$provide_spent_media = $_POST['provide_spent_media'];
	$information_sought = $_POST['information_sought'];
	$result_format = $_POST['result_format'];
	$result_location = $_POST['result_location'];
	$status = $_POST['status'];
	$comment = $_POST['comment'];
	$matrix_comment = $_POST['matrix_comment'];
	$date_analyzed = $_POST['date_analyzed'];
	$date_reviewed = $_POST['date_reviewed'];
		
	$sql="UPDATE `samplesets` SET `experiment_id`='$experiment',`submission_date`='$submission_date',`expected_completion_date`='$expected_completion_date',`submitted_by`='$submitted_by',`submitted_to`='$submitted_to',`analyzed_by`='$analyzed_by',`reviewed_by`='$reviewed_by',`storage_temp`='$storage_temp',`theorized_concentration`='$theorized_concentration',`result_type`='$result_type',`require_raw_data`='$require_raw_data',`provide_spent_media`='$provide_spent_media',`information_sought`='$information_sought',`result_format`='$result_format',`result_location`='$result_location',`status`='$status',`comments`='$comment',`matrix_comments`='$matrix_comment',`date_analyzed`='$date_analyzed' WHERE `id`='$_REQUEST[id]'";
	
	if(@mysql_query($sql))
	{
		header("location:add_sampleset.php?msg=ais&id=$_REQUEST[id]");
	}
	else
	{
		header("location:add_sampleset.php?msg=aif&id=$_REQUEST[id]");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Admin Panel:". $Global['baseurl'];?></title>
<link rel="stylesheet" href="css/admin_style.css" type="text/css" />
<script src="datepicker/jquery-1.3.1.min.js" type="text/javascript"></script>
<script src="datepicker/jquery.ui.core" type="text/javascript"></script>
<script src="datepicker/jquery.ui.core" type="text/javascript"></script>
<script src="datepicker/jquery.ui.datepicker" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<script type="text/javascript">
$(function(){
		var option = {numberOfMonths:1, /*yearRange: "-2:+2",*/ minDate: "1d", dateFormat: "dd-mm-yy"}
		$("#submission_date").datepicker(option);
		$("#expected_completion_date").datepicker(option);
		$("#date_analysed").datepicker(option);
		$("#date_reviewed").datepicker(option);
		
	});
</script>
</head>

<body>
<div class="main_cont">
	<?php include('includes/admin_header.php');?>
		<div class="admin_area">
			<?php include('includes/admin_menubar.php');?>
			<div class="admin_module_area">
				<div class="admin_title"><div class="admin_title_img"><img src="images/icon_content.gif" style="height:30px; vertical-align:middle;" /></div><div class="admin_title_text">Add Sample Sets</div></div><!--admin_title ends-->
				<table width="800">
					<?php @$fetch = mysql_fetch_array(mysql_query("SELECT * FROM `samplesets` WHERE `id`='$_REQUEST[id]'"));?>
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
						<td class="tdhead">Experiment:</td>
						<td>
							<select name="experiment">
								<?php $experiment_select_query = mysql_query("SELECT * FROM `experiments` ORDER BY `id` DESC");
								while($experiment_select = mysql_fetch_array($experiment_select_query)){
								?>
								<option value="<?php echo $experiment_select['name'];?>"><?php echo $experiment_select['name'];?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="tdhead">Submission Date:</td><td><input type="text" name="submission_date" id="submission_date" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Expected Completion Date:</td><td><input type="text" name="expected_completion_date" id="expected_completion_date" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Submitted By:</td><td><input type="text" name="submitted_by" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Submitted To:</td><td><input type="text" name="submitted_to" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Analyzed By:</td><td><input type="text" name="analyzed_by" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Reviewed By:</td><td><input type="text" name="reviewed_by" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Storage Temp:</td><td><input type="text" name="storage_temp" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Theorized Concentration:</td><td><input type="text" name="theorized_concentration" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Result Type:</td><td><input type="text" name="result_type" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Required Raw Data:</td><td><input type="text" name="require_raw_data" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Provide Spent Media:</td><td><input type="text" name="provide_spent_media" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Information Sought:</td><td><input type="text" name="information_sought" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Result Format:</td><td><input type="text" name="result_format" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Result Location:</td><td><input type="text" name="result_location" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Status:</td><td><input type="text" name="status" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Comment:</td><td><textarea name="comment"><?php echo $fetch['name'];?></textarea></td>
					</tr>
					<tr>
						<td class="tdhead">Matrix Comment:</td><td><textarea name="matrix_comment"><?php echo $fetch['name'];?></textarea></td>
					</tr>
					<tr>
						<td class="tdhead">Date Analysed:</td><td><input type="text" name="date_analyzed" id="date_analysed" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
					</tr>
					<tr>
						<td class="tdhead">Date Reviewed:</td><td><input type="text" name="date_reviewed" id="date_reviewed" class="widthtext" value="<?php echo $fetch['name'];?>" /></td>
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
<?php ob_flush();?>
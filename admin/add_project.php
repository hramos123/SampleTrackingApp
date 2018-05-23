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
	
	$sql="INSERT INTO `projects` values('','$title','$description')";
	if(@mysql_query($sql))
	{
		header("location:add_project.php?msg=ais");
	}
	else
	{
		header("location:add_project.php?msg=aif");
	}
}

if(isset($_POST['update']))
{	
	$title = $_POST['title'];
	$description = $_POST['description'];
		
	$sql="UPDATE `projects` SET `name`='$title',`description`='$description' WHERE `id`='$_REQUEST[id]'";
	if(@mysql_query($sql))
	{
		header("location:add_project.php?msg=ais&id=$_REQUEST[id]");
	}
	else
	{
		header("location:add_project.php?msg=aif&id=$_REQUEST[id]");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Admin Panel:". $Global['baseurl'];?></title>
<link rel="stylesheet" href="css/admin_style.css" type="text/css" />
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		width: "660",
		height:"300",
		plugins : "autolink,lists,style,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,emotions,media,imagemanager",
		

		// Theme options
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        /*theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",*/
		theme_advanced_fonts : "Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n;verdana;,",
		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",
		// Drop lists for link/image/media/template dialogs
		//document_base_url : '',
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
</head>

<body>
<div class="main_cont">
	<?php include('includes/admin_header.php');?>
		<div class="admin_area">
			<?php include('includes/admin_menubar.php');?>
			<div class="admin_module_area">
				<div class="admin_title"><div class="admin_title_img"><img src="images/icon_content.gif" style="height:30px; vertical-align:middle;" /></div><div class="admin_title_text">Add Project</div></div><!--admin_title ends-->
				<table width="800">
					<?php @$fetch = mysql_fetch_array(mysql_query("SELECT * FROM `projects` WHERE `id`='$_REQUEST[id]'"));?>
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
						<td class="tdhead">Detail:</td><td><textarea name="description"><?php echo $fetch['description'];?></textarea></td>
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
<?
require_once("admin/config/global.php");
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$id = $_GET['id'];
if(isset($_POST['sid'])){
	$id= $_POST['sid'];
}

if(isset($_POST['startJob'])){
	$q = "update sampleSets set status=(select id from statuses where status = \"In Progress\"), date_analysis_started=NOW() where id=" . $id;
	mysql_query($q) or die (mysql_error());
	
}else if(isset($_POST['update']) or isset($_POST['complete'])){
	
	$tableData = json_decode($_POST['tableData']);
//echo $_POST['tableData'] . "<BR>";
	
	 for ($i = 0; $i < count($tableData); ++$i) {
  		$updateSQL = sprintf("UPDATE samples SET ph=%s, assay_performed=(select id from assays where name=%s) WHERE id=%s",
                       GetSQLValueString($tableData[$i][5], "text"),
                       GetSQLValueString($tableData[$i][4], "text"),
                       GetSQLValueString($tableData[$i][0], "int"));
					   //echo $updateSQL . "<BR>";
  			$Result1 = mysql_query($updateSQL) or die(mysql_error());
	 }
	 $updateSQL = sprintf("UPDATE sampleSets SET  results_location=%s, comments=%s WHERE id=%s",
                       GetSQLValueString($_POST['results_location'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($id, "int"));
					   //echo $updateSQL . "<BR>";
  			$Result1 = mysql_query($updateSQL) or die(mysql_error());
}

$send_review_email = false;
if(isset($_POST['complete'])){
	$q = "update sampleSets set status=(select id from statuses where status = \"Analyzed\"), date_analyzed = NOW() where id=" . $id;
	mysql_query($q) or die (mysql_error());
	$send_review_email = true;
}

$q = "select ss.id, ss.name, results_location, comments, priority, DATE_FORMAT(submission_date, '%c/%d/%Y') as sd, DATE_FORMAT(expected_completion_date, '%c/%d/%Y') as ecd, " .
					"DATE_FORMAT(submission_date, '%c/%d/%Y') as date_submitted, submitted_by, " . 
					"(select CONCAT(first_name, ' ', SUBSTRING(last_name, 1, 1), '.') from staff_list where id=submitted_by) as sb, " . 
					"analyzed_by, " . 
					"(select CONCAT(first_name, ' ', SUBSTRING(last_name, 1, 1), '.') from staff_list where id=analyzed_by) as ab, " .
					"(select email from staff_list where id=analyzed_by) as ab_email, " .
					"(select count(*) as thatsit from samples s where s.sampleset_id=ss.id) as sample_count, " . 
					"status, (select status from statuses s where s.id=ss.status) as status_wd, mailing_list_id, " .
					"(select first_name from staff_list where title='Supervisor' and mailing_list_id=sl.mailing_list_id) as supervisor_name, " .
					"(select email from staff_list where title='Supervisor' and mailing_list_id=sl.mailing_list_id) as supervisor_email " .
					" from sampleSets ss, staff_list sl " .
					" where analyzed_by = sl.id and ss.id= " . $id; 
//echo $q . "<BR>";
$ssq = mysql_query($q) or die(mysql_error());
$sampleSet = mysql_fetch_assoc($ssq);

$q = "SELECT id, sampleset_id, sample_id, name, characterization_requested, (select name from sample_characterizations sc where sc.id=s.characterization_requested) as cr, assay_performed, status, estimated_concentration, measured_concentration, ph, location, analyzed FROM samples s WHERE sampleset_id =" . $id;
$samples = mysql_query($q) or die (mysql_error());

$q = "select * from assays ";
$assays = mysql_query($q) or die (mysql_error());
$ass_count = mysql_num_rows($assays);

if($send_review_email){
	$email_text = "Dear " . $sampleSet['supervisor_name']  . ", <br><br>" . $sampleSet['ab'] . " has just completed analysis of the sample list submitted by " . $sampleSet['sb'] . " on " . $sampleSet['date_submitted'] . " entitled \"" . $sampleSet['name'] . "\".<br><br>";
	$email_text .= "Please review and acknowledge the results <a href=\"" . $Global['baseurl'] . "review.php?id=" . $sampleSet['id'] . "\">here</a>.<br><br>";
	$email_text .= "This email has been automatically generated by the Dendreon Sample Submission Tracking Application.";
		
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	//$headers .= 'To: Hector Ramos <@gmail.com>' . "\r\n"; 	
	$headers .= 'From: DNDN Sample Tracking Application<noreply@dendreon.com>' . "\r\n";
	//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
		
	$to = $sampleSet['supervisor_email'];
	if($Global['debug'] == true){$email_text .= "<BR><BR>DEBUG: this email would have gone to: " . $to; $to = $Global['debug_to'];}
	if($Global['debug'] == false){$headers .= 'Cc: ' . $sampleSet['ab_email'] . "\r\n";}
	$headers .= 'Reply-To: noreply@dendreon.com' . "\r\n";
	mail($to, "Please Review Results", $email_text, $headers);
}
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Sample Set Analysis Page</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory 
        <script src="DataTables-1.9.4/media/js/jquery.js"></script>-->
		<!--<script src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_page.css">
        <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table.css">-->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <!--
          Loading Handsontable (full distribution that includes all dependencies apart from jQuery)
      -->
          <script src="js/vendor/jquery-1.9.0.min.js"></script>
          <script src="jquery-handsontable-master/dist/jquery.handsontable.full.js"></script>
          <link rel="stylesheet" media="screen" href="jquery-handsontable-master/dist/jquery.handsontable.full.css">
 	
    <!-- for the dialog box 
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>-->
	<!-- more for dialog box -->
    <style>
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
</head>

<body>        
  <div role="content" class="clearfix">
    <header class="clearfix" style="padding: 0px; padding-bottom: 10px; margin-bottom: 10px;">
      <h1>Sample Set Analysis</h1>
      <h2>Sample Set Being Analyzed by <?= $sampleSet['ab'] ?></h2>
    </header>
        <script src="js/nav.js"></script>

	<p>Sample Set: <strong><?= $sampleSet['name'] ?></strong></p>
    <p><a href="sampleSetReview.php?id=<?= $id ?>"><img src="images/link_img.png" width="28" height="15" alt="link">Click here to get all the details of this sample set list.</a></p>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= $id ?>" method="post">
    <input type="hidden" name="sid" value="<?= $id ?>"/>
      <? if($sampleSet['status_wd'] == "In Progress"){ ?>
    <table>
      	<tr><td>Results Location:</td><td><input type="text" name="results_location" size=70 value="<?= $sampleSet['results_location'] ?>"/></td></tr>
        <tr><td valign="top">Comments:</td><td><textarea name="comments" rows="5" cols="60"><?= $sampleSet['comments'] ?></textarea></td></tr>
    </table>
    <? }else if($sampleSet['status_wd'] == "Accepted"){  ?>
      <p><input type="submit" name="startJob" value="Click here when you are ready to begin the analysis on these samples." /></p>
	
    	<? }else{ ?>
    	<p>The status of this Sample set list is "<strong><?= $sampleSet['status_wd'] ?></strong>".  As such, this page doesn't show any information about it.  Please see the sample set summary page <a href="sampleSetReview.php?id=<?= $id ?>"> here</a>.</p>
    <? } ?>	
    Sample List:
	<div id="handsomeTable">
              <? $data_str = "[";
                    while($r = mysql_fetch_assoc($samples)){
                        //colHeaders: ['Sample ID', 'Sample Name', 'characterization requested', Assay', 'EST. Conc., ug/mL', 'ph'],
                        if($data_str != "["){ $data_str .= ", ";}
						$data_str .= "[" . $r['id'] . ", '" . $r['sample_id'] . "', '" . $r['name'] . "', '" . $r['cr'] . "', '";
							while($ass = mysql_fetch_assoc($assays)){
								if($ass['id'] == $r['assay_performed']){
									$data_str .= $ass['name'];
								}
						}
						mysql_data_seek($assays, 0);
						$data_str .= "', '" . $r['ph'] . "', '" . $r['estimated_concentration'] . "']"; //, '" . $r['measured_concentration'] . "']";
                        } 
                    $data_str .= "]"; 
                    ?>
	</div>
        <? if($sampleSet['status_wd'] == "In Progress"){ ?>
        <br><br>
		<input type="submit" name="update" value="Save Changes" onClick="$('#tableData').val(JSON.stringify($('#handsomeTable').data('handsontable').getData()));"/> -or- 
		<input type="submit" name="complete" value="Click here when analysis is complete" onClick="$('#tableData').val(JSON.stringify($('#handsomeTable').data('handsontable').getData()));"/><br><BR>
	<? } ?>
	<input type="hidden" name="tableData" id="tableData">
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <footer>
        &nbsp;
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    </footer>
</div>
<? if ($sampleSet['status_wd'] == "In Progress" or $sampleSet['status_wd'] == "Accepted"){ ?> 
<script>
 var data = eval(<?= $data_str ?>);

			var container = $('#handsomeTable');
            container.handsontable({
             data: data,
              startRows: 8,
              startCols: 6,
			  rowHeaders: true,
  			  colHeaders: ['Sample Number', 'Sample Name', 'Characterization Requested', 'Assay', 'ph', 'Estimated Conc.'],
			  minSpareCols: 0,
			  minSpareRows: 0,
              currentRowClassName: 'currentRow',
              currentColClassName: 'currentCol',
			  contextMenu: true,
  			manualColumnResize: true,
			  columns: [
			  		{data: 1, type: 'text', readOnly: true},
			  		{data: 2, type: 'text', readOnly: true},
			  		{data: 3, type: 'text', readOnly: true},
					{
						data: 4, 
					  type: 'autocomplete',
					  source: [ <? $i = 0; while($a = mysql_fetch_assoc($assays)){
						  						if($i++ > 0){echo ", ";}
						  						echo "\"" . $a['name'] . "\"";
					  						} ?>
						  		],
						strict: true, <? if ($sampleSet['status_wd'] != "In Progress"){echo "readOnly: true,";} ?>
						options: {items: <?= $ass_count ?>}
					},
			  		{data: 5, type: 'text'<? if ($sampleSet['status_wd'] != "In Progress"){echo ", readOnly: true,";} ?>},
			  		{data: 6, type: 'text', readOnly: true},
			  		//{data: 8, type: 'text'<? //if ($sampleSet['status_wd'] != "In Progress"){echo ", readOnly: true,";} ?>}
			  		//{data: 7, type: 'checkbox'}
				]
			});
</script>
<? } ?>
</body>
</html>
<?
mysql_free_result($ssq);
mysql_free_result($samples);
mysql_free_result($assays);
?>
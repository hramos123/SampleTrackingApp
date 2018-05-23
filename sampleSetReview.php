<?php require_once('admin/config/global.php'); ?>
<?php
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$prev_page = $_SERVER['HTTP_REFERER'];
$missingAssay = false;
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE sampleSets SET comments=%s, priority=%s, status=%s, submitted_to=%s, expected_completion_date=%s WHERE id=%s",
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['priority'], "int"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['submitted_to'], "int"),
                       GetSQLValueString($_POST['expected_completion_date'], "date"),
                       GetSQLValueString($_POST['id'], "int"));
  //echo $updateSQL . "<BR>";
  $Result1 = mysql_query($updateSQL) or die(mysql_error());
  //echo $_POST['tableData'] . "<BR>";
  $myArr =  json_decode($_POST['tableData']);
	for($i = 0; $i < count($myArr); $i++) {
		$updateSQL = "update samples set assay_performed = (select id from assays where name=\"" . $myArr[$i][4] . "\") where id=" . $myArr[$i][0]; //, measured_concentration = \"" . $myArr[$i][8] . "\"
		if($myArr[$i][4] ==""){$missingAssay  = true;}//echo $updateSQL . "<BR>";
		mysql_query($updateSQL) or die('Invalid query: ' . mysql_error());
	}
	$prev_page = $_POST['prev_page'];
}

$query_Recordset1 = "SELECT * FROM sampleSets where id=" . $_GET['id'];
$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


$colname_Recordset2 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset2 = $_GET['id'];
}

$query_Recordset2 = sprintf("SELECT id, sampleset_id, sample_id, name, characterization_requested, (select name from sample_characterizations sc where sc.id=s.characterization_requested) as cr, assay_performed, status, estimated_concentration, measured_concentration, ph, location, analyzed FROM samples s WHERE sampleset_id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2) or die(mysql_error());

$experiments = mysql_query("select e.id, concat(e.name, ' (', p.name, ')') as name, e.description, goal from experiments e, projects p where p.id=e.project_id order by name") or die (mysql_error());
$users = mysql_query("select id, CONCAT(first_name, ' ', SUBSTRING(last_name, 1, 1), '.') as name from staff_list order by name") or die (mysql_error());
$statuses = mysql_query("select * from statuses") or die (mysql_error());

$a = "select * from assays order by name";
$assays = mysql_query($a) or die(mysql_error);
$assay_count = mysql_num_rows($assays);

//get status
$status_wd = "";
while($status = mysql_fetch_assoc($statuses)){
	if($status['id'] == $row_Recordset1['status']){
		$status_wd = $status['status'];
	}
}
mysql_data_seek($statuses, 0);
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Sample Set Review</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<? if(isset($_POST['MM_update']) and !$missingAssay and $status_wd=="Submitted" and preg_match("/dispatch/", $prev_page)){ ?>
				<meta http-equiv="refresh" content="0; url=<?= $prev_page ?>">
           <? } ?>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <!--
          Loading Handsontable (full distribution that includes all dependencies apart from jQuery)
      -->
          <script src="js/vendor/jquery-1.9.0.min.js"></script>
          <script src="jquery-handsontable-master/dist/jquery.handsontable.full.js"></script>
          <link rel="stylesheet" media="screen" href="jquery-handsontable-master/dist/jquery.handsontable.full.css">
  
  <style>
  h2{ color: #ea8300;margin: .5em 0;}
  section{margin-bottom: 20px;}
  </style>
    </head>
<body>
        <div role="content" class="clearfix">
        <header class="clearfix" style="padding: 0px; padding-bottom: 10px; margin-bottom: 10px;">
        	<h1>Sample Set Review</h1>
            
        </header>
        <script src="js/nav.js"></script>
        <p><a href="<?= $prev_page ?>">&lt;&lt; Back</a></p>
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
 <section class="clearfix">
  <h2>Sample Set Information</h2>
  <div style="float:left;">
  <table class="coloredRowsTable" align="center">
    <tr valign="baseline">
      <td nowrap align="right">Sample Set Name:</td>
      <td><input type="text" name="name" value="<?php echo htmlentities($row_Recordset1['name'], ENT_COMPAT, 'utf-8'); ?>" size="25" disabled></td>
      <td nowrap align="right">Belongs to Experiment:</td>
      <td>
      <? $exp_desc = "";
		 $exp_goal = "";
	  	
		while($ex = mysql_fetch_assoc($experiments)){ 
	  		if($ex['id'] == $row_Recordset1['experiment_id']){ ?>
                <input type="text" name="experiment_id" value="<?=$ex['name'] ?>" size="25" disabled>
          <? 	 $exp_desc = $ex['description'];
                 $exp_goal = $ex['goal'];
	  		} 
	  } ?>  
      <div onmouseover="document.getElementById('tt1').style.display='block'" onmouseout="document.getElementById('tt1').style.display='none'" class="questionMark"><div id="tt1" class="popupToolTip" style="display: none;"><strong>Experiment Description</strong>: <?= $exp_desc ?>.<br><strong>Experiment Goal</strong>: <?= $exp_goal ?>.</div></div>

        </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Location of Samples:</td>
      <td><input type="text" name="sampleLocation" value="<?php echo htmlentities($row_Recordset1['samples_location'], ENT_COMPAT, 'utf-8'); ?>" size="15" disabled></td>
      <td nowrap align="right">Keep Samples:</td>
      <td><input type="text" name="keepSamples" size="3" value="<?php echo htmlentities($row_Recordset1['keep_samples'], ENT_COMPAT, 'utf-8'); ?>" disabled><? if($row_Recordset1['keep_samples'] == "yes"){ ?>&nbsp;&nbsp;&nbsp;Where: <input type="text" name="storeWhere" value="<?= htmlentities($row_Recordset1['store_where'], ENT_COMPAT, 'utf-8'); ?>" size="13" disabled> <? } ?></td>
    </tr>
    <tr valign="baseline">
          <td nowrap align="right">Storage Temp:</td>
      <td><input type="text" name="storage_temp" value="<?php echo htmlentities($row_Recordset1['storage_temp'], ENT_COMPAT, 'utf-8'); ?>" size="15" disabled></td>
      <td nowrap align="right">Chromatogram Overlays:</td>
      <td><input type="text" name="chromatograms" value="<?php echo $row_Recordset1['chromatogram_overlays'] == 1 ? "Yes" : "No"; ?>" size="15" disabled></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Require Raw Data:</td>
      <td><input type="text" name="require_raw_data" value="<?php echo $row_Recordset1['require_raw_data'] == 1 ? "Yes" : "No"; ?>" size="15" disabled></td>
      <td nowrap align="right">Information Sought:</td>
      <td><input type="text" name="information_sought" value="<?php echo htmlentities($row_Recordset1['information_sought'], ENT_COMPAT, 'utf-8'); ?>" size="32" disabled></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Provide Spent Media:</td>
      <td><input type="text" name="provide_spent_media" value="<?php echo $row_Recordset1['provide_spent_media'] == 1 ? "Yes" : "No"; ?>" size="15" disabled></td>
      <td nowrap align="right">Chemical Composition of Matrix:</td>
      <td><input type="text" name="matrix_comments" value="<?php echo htmlentities($row_Recordset1['matrix_comments'], ENT_COMPAT, 'utf-8'); ?>" size="32" disabled></td>
    </tr>
    <tr>
          <td nowrap align="right">Comments:</td>
      <td><textarea name="comments" rows="5" cols="35"><?php echo htmlentities($row_Recordset1['comments'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
		<td></td><td></td>
     </tr>
  </table>
</div>
    </section>
 <section class="clearfix">
    <div style="float:left;">
      <h2>Dispatch Information</h2>
    <table class="coloredRowsTable">
    <tr valign="baseline">
      <td nowrap align="right">Priority:</td>
      <td><input type="number" name="priority" min="1" max="5" value="<?php echo htmlentities($row_Recordset1['priority'], ENT_COMPAT, 'utf-8'); ?>" \></td>
      <td nowrap align="right">Status:</td>
      <td><select name="status">
      	<? while($status = mysql_fetch_assoc($statuses)){ ?>
        	<option value="<?= $status['id']?>" <? if($row_Recordset1['status'] == $status['id']){ echo "selected";} ?>><?= $status['status'] ?></option>
      	<? } ?>
        </select>
        </td>
    </tr>
    <tr valign="baseline">
            <td nowrap align="right">Submitted By:</td>
      <td>
      	<?
		   while($usr = mysql_fetch_assoc($users)){ 
		   if($row_Recordset1['submitted_by'] == $usr['id']){ ?>
        		<input type="text" name="submitted_by"  value="<?= $usr['name']?>" size="10" disabled>
        <? }} ?>      
      </select></td>
      <td nowrap align="right">Submission Date:</td>
      <td class="noSpinner" ><input name="submission_date" type="date" value="<?php echo date('Y-m-d', strtotime($row_Recordset1['submission_date'])); ?>" disabled></td>
    </tr>
        <tr valign="baseline">
            <td nowrap align="right">Submitted To:</td>
      <td><select name="submitted_to">
      	<? mysql_data_seek($users, 0); 
			while($usr = mysql_fetch_assoc($users)){ ?>
        	<option value="<?= $usr['id']?>" <? if($row_Recordset1['submitted_to'] == $usr['id']){echo "selected";} ?>><?= $usr['name']?></option>
        <? } ?>      
      </select></td> 
            <td nowrap align="right">Expected Date:</td>
      <td class="noSpinner"><input type="date" name="expected_completion_date" value="<?php echo date('Y-m-d', strtotime($row_Recordset1['expected_completion_date'])); ?>"></td>

	</tr>
    
	</table>
    </div>
    </section>
 <section class="clearfix">
    <a name="samples"></a><h2>Sample Information</h2>
          <div id="handsomeTable">
          <? $data_str = "[";
                    while($r = mysql_fetch_assoc($Recordset2)){
                        //colHeaders: ['Sample ID', 'Sample name', 'Characterization Requested', 'Assay', 'ph', 'EST. Conc., ug/mL', 'Measured Conc.'],
                        if($data_str != "["){ $data_str .= ", ";}
                        $data_str .= "[" . $r['id'] . ", '" . $r['sample_id'] . "', '" . $r['name'] . "', '" . $r['cr'] . "', '";
							while($ass = mysql_fetch_assoc($assays)){
								if($ass['id'] == $r['assay_performed']){
									$data_str .=  $ass['name'];
								}
							}
							mysql_data_seek($assays, 0);
							$data_str .=  "', '" . $r['ph'] . "', '" . $r['estimated_concentration'] . "', '" . $r['measured_concentration'] . "']";
                    } 
                    $data_str .= "]"; 
                    ?>
           </div>
     </section>
 <section class="clearfix">
	<div style="float: left;">
  <h2>Results</h2>
  <table class="coloredRowsTable">
  <tr>
          <td nowrap align="right">Analyzed By:</td>
      <td><select name="analyzed_by" disabled>
        <option></option>
      	<? mysql_data_seek($users, 0);
			while($usr = mysql_fetch_assoc($users)){ ?>
        	<option value="<?= $usr['id']?>" <? if($row_Recordset1['analyzed_by'] == $usr['id']){echo "selected";} ?>><?= $usr['name']?></option>
        <? } ?>      
      </select></td>
      <td nowrap align="right">Date Analyzed:</td>
      <td class="noSpinner"><input type="date" name="date_analyzed" value="<?php if($row_Recordset1['date_analyzed'] != ""){echo date('Y-m-d', strtotime($row_Recordset1['date_analyzed'])); }?>" disabled></td>
    </tr>
    <tr valign="baseline">
            <td nowrap align="right">Reviewed By:</td>

      <td><select name="reviewed_by" disabled>
      	<option></option>
      	<? mysql_data_seek($users, 0);
			while($usr = mysql_fetch_assoc($users)){ ?>
        	<option value="<?= $usr['id']?>" <? if($row_Recordset1['reviewed_by'] == $usr['id']){echo "selected";} ?>><?= $usr['name']?></option>
        <? } ?>      
      </select></td>
<td nowrap align="right">Date Reviewed:</td>
      <td class="noSpinner"><input type="date" name="date_reviewed" value="<?php if($row_Recordset1['date_reviewed'] != ""){echo date('Y-m-d', strtotime($row_Recordset1['date_reviewed'])); }?>" disabled></td>
    
    </tr>
    <tr>
      <td nowrap align="right">Results Location:</td>
      <td colspan="3"><a href="file:///<?php echo htmlentities($row_Recordset1['results_location'], ENT_COMPAT, 'utf-8'); ?>"><?php echo htmlentities($row_Recordset1['results_location'], ENT_COMPAT, 'utf-8'); ?></a></td>
	</tr>
      <tr valign="baseline">
      <td nowrap align="right">Result Type:</td>
      <td><input type="text" name="result_type" value="<?php echo htmlentities($row_Recordset1['result_type'], ENT_COMPAT, 'utf-8'); ?>" size="20" disabled></td>
	</tr>
    </table>
    </div>
   </section>
    <input type="hidden" name="tableData" id="tableData">
       <center><p><input type="submit" id="send" value="Save Changes" onClick="$('#tableData').val(JSON.stringify($('#handsomeTable').data('handsontable').getData()));"></p></center>
     	
    
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="id" value="<?php echo $row_Recordset1['id']; ?>">
    <input type="hidden" name="prev_page" value="<?php echo $prev_page; ?>">
        </form>
</div>
<script>
 var data = eval(<?= $data_str ?>);

			var container = $("#handsomeTable");
            container.handsontable({
             data: data,
              startRows: 8,
              startCols: 6,
			  rowHeaders: true,
  			  colHeaders: ['Sample Number', 'Sample Name', 'Characterization Requested', 'Assay', 'ph', 'Est. Conc.'],
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
						strict: true,
					  options: {
						items: <?= $assay_count ?> //`options` overrides `defaults` defined in bootstrap typeahead
					  }
						
					},
			  		{data: 5, type: 'text', readOnly: true},
			  		{data: 6, type: 'text', readOnly: true},
			  		//{data: 8, type: 'text'}
			  		//{data: 7, type: 'checkbox'}
				]
			});
</script>
        <footer>
        	<p>&nbsp;</p>
        	<p>&nbsp;</p>
        	<p>&nbsp;</p>
        	<p>&nbsp;</p>
        </footer>
</body>
</html>
<? 
mysql_free_result($Recordset2);

mysql_free_result($Recordset1);
mysql_free_result($experiments);
mysql_free_result($users);
mysql_free_result($statuses);
mysql_free_result($assays);
?>
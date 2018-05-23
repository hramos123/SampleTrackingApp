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
		
$start_date = mktime() - 30 * 3600 * 24;//1 month ago
$end_date = mktime();
$start_date = strtotime("2018/01/01"); //mktime() - 30 * 3600 * 24;//1 month ago
$end_date = strtotime("2018/06/01"); //mktime();
if(isset($_GET['start_date'])){
	$start_date = strtotime(str_replace('-', '/', $_GET['start_date']));
}
if(isset($_GET['end_date'])){
	$end_date = strtotime(str_replace('-', '/', $_GET['end_date']));
}
//echo $start_date . " (" . date("Y-m-d", $start_date) . ")<BR>" . $end_date . " (" . date("Y-m-d", $end_date) . ")<br>";
//$dd=dateDifference($end_date, $start_date);
//echo $dd[0] . " - " . $dd[1] . " - " . $dd[2] . "<BR>";

$time_interval = "interval " . floor(($end_date-$start_date)/(3600*24) ) . " day ";
require_once('phpscripts/reports.php');

$samplesSubmittedPerDay = mysql_query($samplesSubmittedPerDay_sql) or die(mysql_error());
$samplesAnalyzedPerDay = mysql_query($samplesAnalyzedPerDay_sql) or die(mysql_error());
$samplesPerGroup = mysql_query($samplesPerGroupSQL) or die(mysql_error());
$samplesPerSubmittor = mysql_query($samplesPerSubmittorSQL) or die(mysql_error());
$samplesPerAnalyst = mysql_query($samplesPerAnalystSQL) or die(mysql_error());
$analyses_count = mysql_query($analyses_count_sql) or die(mysql_error());
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width"><script type="text/javascript" src="https://www.google.com/jsapi"></script>
    	<script type="text/javascript">
      	google.load("visualization", "1", {packages:["corechart"]});
		function drawChart() {
        var options = {
          title: 'Samples Submitted and Analyzed'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <!--<script src="DataTables-1.9.4/media/js/jquery.js"></script>
		<script src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_page.css">
        <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table.css">-->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        
        <!--  <script src="js/vendor/modernizr-2.6.2.min.js"></script>
          Loading Handsontable (full distribution that includes all dependencies apart from jQuery)
      
          <script src="js/vendor/jquery-1.9.0.min.js"></script>
          <script src="jquery-handsontable-master/dist/jquery.handsontable.full.js"></script>
          <link rel="stylesheet" media="screen" href="jquery-handsontable-master/dist/jquery.handsontable.full.css">

  <script>
	    $(document).ready( function () {
	      $('#splTable').dataTable( {
	        "bPaginate": false,
			"bAutoWidth":false,
			"aoColumns": [ 
			/* link */   null,
			/* name */  null,
			/* submitted */    null,
			/* Required */    null,
			/* By */    null,
			/* To */    null,
			/* Samples */    null,
			/* Status */    null,
			/* Priority */    null,
			/* quick link */    null,
			/* Platform { "bSearchable": false,
			                 "bVisible":    false }, */
			/* Samplenames */   { "bVisible":    false } 
		]
	      });
	    });
	 </script>
       -->
    </head>
    <body>	
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div role="content" class="clearfix">
        <header>
        	<h1>Dendreon Sample Tracking Application</h1>
            <h2>Reports</h2>
        </header>
        <script src="js/nav.js"></script>
        <div class="reportDates noSpinner">
        	<form action="reports.php" method="get">
        	<p><strong>&nbsp;Beginning on:</strong> <input type="date" name="start_date" value="<?= date("Y-m-d",$start_date) ?>">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Through:</strong><input type="date" name="end_date" value="<?= date("Y-m-d",$end_date) ?>"> &nbsp;&nbsp;<input type="submit" name="submit"></p>
            </form>
        </div>
        <div>
        <div class="sectionHeader">Sample Submissions </div>
            
                
            <?
			$table_html = "<table class=\"splTable\"><tbody>";
			$submitted_sum = 0;
			$analyzed_sum = 0;
			$dataTable_str = "var data = new google.visualization.DataTable();";
			$dataTable_str .= "data.addColumn('date', 'Date');";
			$dataTable_str .= "data.addColumn('number', 'Submitted');";
			$dataTable_str .= "data.addColumn('number', 'Analyzed');";

				while($row_ss = mysql_fetch_assoc($samplesSubmittedPerDay)){
					 $row_sa = mysql_fetch_assoc($samplesAnalyzedPerDay);
					//$table_html .= "<tr><td>" . date("m/d/Y", strtotime($row_ss['selected_date'])) . "</td>" .
						 "<td align=\"center\">" . $row_ss['count_'] . "</td>" . 
						 "<td align=\"center\">" . $row_sa['count_'] . "</td>" . 
						 "</tr>";
					$submitted_sum += $row_ss['count_'];
					$analyzed_sum  += $row_sa['count_'];
					$dataTable_str .= "data.addRow([new Date(" . date("Y", strtotime($row_ss['selected_date'])) . ", " . date("m", strtotime($row_ss['selected_date'])) . " - 1 , " . date("d", strtotime($row_ss['selected_date'])) . "), " . $row_ss['count_'] . ", " . $row_sa['count_'] . "]);";
				}		
				//echo $dataTable_str;			
				$table_html .= "<tr><td><strong><u>Date Range</u><strong></td><td>" . date("m/d/Y", $start_date) . " - " . date("m/d/Y", $end_date) . "</td>";
				$table_html .= "<tr><td><strong><u>Samples Submitted</u><strong></td><td align=\"center\">" . $submitted_sum . "</td>";
				$table_html .= "<tr><td><strong><u>Samples Analyzed</u><strong></td><td align=\"center\">" . $analyzed_sum . "</td></tr>";
				$table_html .= "</tbody></table>";
			?>
                        
            <div id="chart_div"></div>
            <script><?= $dataTable_str ?>drawChart();</script>
            <p>&nbsp;</p>
            <?= $table_html ?>
            </div>
            <p>&nbsp;</p>
            <div>
        	<div class="sectionHeader">Sample Statistics</div>
            
            <table class="splTable">
            	<thead><th>Group</th><th>Submissions</th><th>Analyzed</th><th>Assays</th></thead>
                <? while($rs = mysql_fetch_assoc($samplesPerGroup)){ ?>
                	<tr><td><?= $rs['name'] ?></td><td><?= $rs['submission_count'] ?></td><td><?= $rs['analyzed_count'] ?></td><td><?= $rs['assays_done'] ?></td></tr>
                <? } ?>
            </table>
            </div>
            <p>&nbsp;</p>
            <div>
            <div class="sectionHeader">Top Customers/Submittors</div>
            <table class="splTable">
            	<thead><th width="125px">Submittor</th><th width="125px">Submissions</th><th>Sample Characterizations Requested</th></thead>
                <? while($rs = mysql_fetch_assoc($samplesPerSubmittor)){ ?>
                	<tr><td><?= $rs['first_name'] ?></td><td align="center"><?= $rs['submission_count'] ?></td><td><?= $rs['characterizations_requested'] ?></td></tr>
                <? } ?>
            </table>
            </div>
            <p>&nbsp;</p>
            <div>
            <div class="sectionHeader">Analyses Break Down</div>
            <table class="splTable">
            	<thead><th width="125px">Analyst</th><th width="145px">Samples Analyzed</th><th>Assays</th></thead>
                <? while($rs = mysql_fetch_assoc($samplesPerAnalyst)){ ?>
                	<tr><td><?= $rs['first_name'] ?></td><td align="center"><?= $rs['analyzed_count'] ?></td><td><?= $rs['assays_done'] ?></td></tr>
                <? } ?>
            </table>
            </div>
            <p>&nbsp;</p>
            <div>
            <div class="sectionHeader">Assays Performed</div>
            <table class="splTable">
            	<thead><th width="125px">Assay</th><th width="145px">Count</th></thead>
                <? while($rs = mysql_fetch_assoc($analyses_count)){ ?>
                	<tr><td><?= $rs['name'] ?></td><td align="center"><?= $rs['count_'] ?></td></tr>
                <? } ?>
            </table>
            </div>
        <footer>
        	&nbsp;
        </footer>
</div>
<script>drawChart();</script>
<body>
</body>
</html>    
<?php
	mysql_free_result($samplesSubmittedPerDay);
	mysql_free_result($samplesAnalyzedPerDay);
	mysql_free_result($samplesPerGroup);
	mysql_free_result($samplesPerSubmittor);
	mysql_free_result($samplesPerAnalyst);
	mysql_free_result($analyses_count);
?>

<?php require_once('admin/config/global.php'); //db connection info ?>
<?php require_once('src/dbutils/DBUtils.php'); //db utilities/functions ?>
<?php

$query_sampleLists = "select ss.id, ss.name, priority, DATE_FORMAT(submission_date, '%c/%d/%Y') as sd, DATE_FORMAT(expected_completion_date, '%c/%d/%Y') as ecd, " .
					"(select mailing_list_id from staff_list sl where sl.id=ss.submitted_to) as ml_id, " .
					"(select CONCAT(first_name, ' ', SUBSTRING(last_name, 1, 1), '.') as thatsit from staff_list sl where sl.id=ss.submitted_by) as sb, " . 
					"(select CONCAT(first_name, ' ', SUBSTRING(last_name, 1, 1), '.') as thatsit from staff_list sl where sl.id=ss.submitted_to) as st, " . 
					"(select count(*) as thatsit from samples s where s.sampleset_id=ss.id) as sample_count, " . 
					"(select status from statuses s where s.id=ss.status) as status, " .
					" group_concat(s.name) as sample_names from sampleSets ss, samples s where s.sampleset_id=ss.id   " .
					" group by ss.id order by sd desc";
					////and DATE(submission_date) > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
//echo $query_sampleLists . "<BR>";
$sampleLists = mysql_query($query_sampleLists) or die(mysql_error());
$totalRows_sampleLists = mysql_num_rows($sampleLists);
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
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <script src="DataTables-1.9.4/media/js/jquery.js"></script>
		<script src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_page.css">
        <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <!--
          Loading Handsontable (full distribution that includes all dependencies apart from jQuery)
      
          <script src="js/vendor/jquery-1.9.0.min.js"></script>
          <script src="jquery-handsontable-master/dist/jquery.handsontable.full.js"></script>
          <link rel="stylesheet" media="screen" href="jquery-handsontable-master/dist/jquery.handsontable.full.css">
  -->
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
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div role="content" class="clearfix">
        <header>
        	<h1>Dendreon Sample Tracking Application</h1>
        </header>
        <script src="js/nav.js"></script>
        <div class="sectionHeader">Sample Sets in the Queue</div>
            <table id="splTable">
            	<thead><tr><th></th><th>Name</th><th> Submitted</th><th> Required</th><th> By</th><th> To</th><th>Samples</th><th>Status</th><th>Priority</th><th>Quick Link</th><th>sn</th></tr></thead>
                <tbody>
            <?
				while($row_sl = mysql_fetch_assoc($sampleLists)){
					echo "<tr><td><a href=\"sampleSetReview.php?id=" . $row_sl['id'] . "\"><img src=\"images/link_img.png\"></a></td><td>" . $row_sl['name'] . "</td><td>" . $row_sl['sd'] . "</td><td>" . $row_sl['ecd'] . "</td><td>" . $row_sl['sb'] . "</td><td>" . $row_sl['st'] . "</td><td>" . $row_sl['sample_count'] . "</td><td>" . $row_sl['status'] . "</td><td align=\"center\">" . $row_sl['priority'] . "</td>";
					echo "<td>";
					if($row_sl['status'] == "Submitted"){
						echo "<a href=\"dispatch.php?ml_id=" . $row_sl['ml_id'] . "\">Dispatch Queue</a>";
					}elseif($row_sl['status'] == "Accepted" or $row_sl['status'] == "In Progress"){
						echo "<a href=\"analysis.php?id=" . $row_sl['id'] . "\">Analysis Page</a>";
					}elseif($row_sl['status'] == "Analyzed"){
						echo "<a href=\"review.php?id=" . $row_sl['id'] . "\">Review Page</a>";
					}
					echo "</td><td>" . $row_sl['sample_names'] . "</td></tr>";
				}
			?>
            </tbody>
            </table>
        <footer>
        	&nbsp;
        </footer>
</div>
<body>
</body>
</html>    
<?php
	mysql_free_result($sampleLists);
?>

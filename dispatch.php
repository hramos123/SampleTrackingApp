<?php require_once('admin/config/global.php'); ?>
<?php

$ml_id = urldecode($_GET['ml_id']);

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

$query_staff_names = "select id, CONCAT(first_name, ' ', SUBSTRING(last_name, 1, 1), '.') as name from staff_list  where mailing_list_id = " . $ml_id . " order by name";
$staff_names = mysql_query($query_staff_names) or die(mysql_error());

$query_mailing_list = "select  * from mailing_lists  where id = " . $ml_id;
$mailing_list = mysql_query($query_mailing_list) or die(mysql_error());
$ml = mysql_fetch_assoc($mailing_list);

$query_samplesets = "select ss.id, ss.name, priority, DATE_FORMAT(submission_date, '%c/%d/%Y') as sd, DATE_FORMAT(expected_completion_date, '%c/%d/%Y') as ecd, " .
					"submitted_by, (select CONCAT(first_name, ' ', SUBSTRING(last_name, 1, 1), '.') from staff_list where id=submitted_by) as sb, " . 
					"submitted_to as st, " . 
					"(select count(*) as thatsit from samples s where s.sampleset_id=ss.id and assay_performed is NULL) as unassigned_assay_count, " .
					"(select count(*) as thatsit from samples s where s.sampleset_id=ss.id) as sample_count, " . 
					"status, (select status from statuses s where s.id=ss.status) as status_wd " .
					" from sampleSets ss, staff_list sl " .
					" where submitted_to = sl.id and sl.mailing_list_id= " . $ml_id . " and status  = (select id from statuses where status = 'Submitted') order by submission_date desc";

$samplesets = mysql_query($query_samplesets) or die(mysql_error());

?>
<!DOCTYPE HTML>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Sample Submission Dispatcher</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory 
        <script src="DataTables-1.9.4/media/js/jquery.js"></script>-->
          <script src="js/vendor/jquery-1.9.0.min.js"></script>
		<script src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_page.css">
        <link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <!--
          Loading Handsontable (full distribution that includes all dependencies apart from jQuery)
      -->
          <script src="jquery-handsontable-master/dist/jquery.handsontable.full.js"></script>
          <link rel="stylesheet" media="screen" href="jquery-handsontable-master/dist/jquery.handsontable.full.css">
 	
    <!-- for the dialog box -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
		<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<!-- more for dialog box -->
    <style>
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
  <script>
  var groupName = "<?= $ml['name'] ?>";
  var SSname;
  var rejID;
  var subBy;
	$(function() {
	  var reason = $( "#reason" ),
		allFields = $( [] ).add( reason ), tips = $( ".validateTips" );
   
	  function updateTips( t ) {
		tips
		  .text( t )
		  .addClass( "ui-state-highlight" );
		setTimeout(function() {
		  tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	  }
   
	  function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
		  o.addClass( "ui-state-error" );
		  updateTips( "Length of " + n + " must be between " +
			min + " and " + max + "." );
		  return false;
		} else {
		  return true;
		}
	  }
   
	  function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
		  o.addClass( "ui-state-error" );
		  updateTips( n );
		  return false;
		} else {
		  return true;
		}
	  }
   
	  $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 450,
		width: 500,
		modal: true,
		buttons: {
		  "Reject": function() {
			var bValid = true;
			allFields.removeClass( "ui-state-error" );
   
			bValid = bValid && checkLength( reason, "Reason", 3, 128 );
			//bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_ ])+$/i, "Name may consist of a-z, 0-9, underscores, begin with a letter." );
			if ( bValid ) {
				$.get("ajax/accept_or_rejectSPL.php", 
				{ id: rejID, name: encodeURIComponent(SSname), type: "reject", group: groupName, reason: reason.val(), st: $("#submitted_to-" + rejID).val(), original_submitted_to: $("#orig_st-" + rejID).val(), sb: subBy},
				function(data){
					//var data1 = eval("(" + data + ")");
				    $('#resultsDiv').html(data + "<p><a href=\"#\" onClick=\"toggleDivs()\">Go back to list of Sample Submissions</a></p>");
  				 });
			  $( this ).dialog( "close" );
			  toggleDivs();
			  $('#splTable').dataTable().fnDeleteRow( $('#splTable').dataTable().fnGetPosition( document.getElementById('row_' + rejID) ))
			}
		  },
		  Cancel: function() {
			$( this ).dialog( "close" );
		  }
		},
		close: function() {
		  allFields.val( "" ).removeClass( "ui-state-error" );
		  updateTips("");
		}
	  });
	  /*$( "#create-user" )
		.button()
		.click(function() {
		  $( "#dialog-form" ).dialog( "open" );
		});*/
	      $('#splTable').dataTable( {
	        "bPaginate": false,
			"bAutoWidth":false,
	      });
		  if(typeof console === "undefined"){
			console = { log: function() { } };
		  }
		  console.log("doc ready");
	});
	  
   function toggleDivs(){
	   	if($('#landing').css('display') == 'block'){
			  $('#landing').hide();
			  $('#resultsDiv').show();
		}else{
			  $('#resultsDiv').hide();
			  $('#landing').show();
		}
   }
   
   function acceptTask(id_, st_, ost, sb_, nm){
	  $.get("ajax/accept_or_rejectSPL.php", 
		  { id: id_, name: encodeURIComponent(nm), group: "<?= $ml['name'] ?>", type: "accept", st: st_, original_submitted_to: ost, sb: sb_},
		  function(data){
			  //var data1 = eval("(" + data + ")");
			  $('#resultsDiv').html(data + "<p><a href=\"#\" onClick=\"toggleDivs()\">Go back to list of Sample Submissions</a></p>");
		   });
		toggleDivs();
		$('#splTable').dataTable().fnDeleteRow( $('#splTable').dataTable().fnGetPosition( document.getElementById('row_' + id_) ))
   }
  </script>
</head>

<body> 
        <div role="content" class="clearfix">
        <header class="clearfix" style="padding: 0px; padding-bottom: 10px; margin-bottom: 10px;">
        	<h1 >Sample Set Dispatch Queue</h1>
            <h2 >Samples awaiting approval by <?= $ml['name'] ?></h2>
            
        </header>
        <script src="js/nav.js"></script>
        <div id="landing">
        <p>Accept the task as submitted, or reassign it to a different analyst, or reject the submission (and tell the submitter why).  When the sample set is accepted, the person who submitted the request will be notified of your changes.</p>
        <p>Click on the link icon if you need to see more information about the sample set.</p>
        <p>Once the sample set is accepted or rejected, the submitter will be notified.</p>
                    <table id="splTable">
            	<thead><tr><th>Details</th><th>Name</th><th> Submitted</th><th> Required</th><th> By</th><th> To</th><th>Samples</th><th>Status</th><th>Priority</th><th></th><th></th><th></th></tr></thead>
                <tbody>
            <?
				while($row_sl = mysql_fetch_assoc($samplesets)){
					echo "<tr id=\"row_" . $row_sl['id'] . "\"><td><a href=\"sampleSetReview.php?id=" . $row_sl['id'] . "\"><img src=\"images/link_img.png\"></a></td>";
					echo "<td>" . $row_sl['name'] . "</td>";
					echo "<td>" . $row_sl['sd'] . "</td><td>" . $row_sl['ecd'] . "</td>";
					echo "<td>" . $row_sl['sb'] . "</td><td>\n<input type=\"hidden\" name =\"orig_st-" . $row_sl['id'] . "\" id=\"orig_st-" . $row_sl['id'] . "\" value=\"" . $row_sl['st'] . "\"/><select name=\"submitted_to-" . $row_sl['id'] . "\" id=\"submitted_to-" . $row_sl['id'] . "\">";
					mysql_data_seek($staff_names, 0);
					while($sl = mysql_fetch_assoc($staff_names)){
						echo "\n<option value=\"" . $sl['id'] . "\" ";
						if($row_sl['st'] == $sl['id']){echo "selected";}
						echo ">" . $sl['name'] . "</option> ";
					}
					echo "</select></td><td align=\"center\">" . $row_sl['sample_count'] . "</td><td align=\"center\">" . $row_sl['status_wd'] . "</td><td align=\"center\">" . $row_sl['priority'] . "</td>"; 
					echo "\n<td><button type=\"button\" name=\"assign_assays-" . $row_sl['id'] . "\" onClick=\"location.href='sampleSetReview.php?id=" . $row_sl['id'] . "#samples'\">Specify Assays</button></td>\n";
					echo "\n<td><button type=\"button\" name=\"accept-" . $row_sl['id'] . "\" onClick=\"if(" . $row_sl['unassigned_assay_count'] . " > 0){alert('Before accepting a sample set submission for analysis, you must first assign an assay to be ran on each sample.');}else{acceptTask(" . $row_sl['id'] . ", $('#submitted_to-" . $row_sl['id'] . "').val(), " . $row_sl['st'] . ", " . $row_sl['submitted_by'] . ", '" . preg_replace("/'/", "\'", $row_sl['name']) . "');}\">Accept</button></td>\n";
					echo "<td><button type=\"button\" onClick=\"showRejectDialog(" . $row_sl['id'] . ", '" . preg_replace("/'/", "\'", $row_sl['name']) . "', " . $row_sl['submitted_by'] . ");\" name=\"reject-" . $row_sl['id'] . "\">Reject</button></td></tr>";
				}
			?>
            </tbody>
            </table>
            </div>
            <div id="resultsDiv"></div>
<p>&nbsp;</p>
<p>&nbsp;</p>
        <footer>
        	&nbsp;
        </footer>
</div>
<script>
	function showRejectDialog(id, name, sb){
		$('#sampleRejectName').text("Sample Set Name: " + name);
		SSname = name;
		rejID = id;
		subBy = sb;
		$( "#dialog-form" ).dialog( "open" );
	};
</script>
        <div id="dialog-form" title="Reject Sample Submission">
            <p id="sampleRejectName"></p>
              <form>
              <fieldset>
                <label for="reason">Please give a reason for your rejection:</label><br>
                <textarea name="reason" id="reason"  cols="40"  rows="5"class="text ui-widget-content ui-corner-all" ></textarea><br>
              </fieldset>
              </form>
            <p class="validateTips"></p>
        </div>
</body>
</html>
<?
mysql_free_result($staff_names);
mysql_free_result($samplesets);
mysql_free_result($mailing_list);
?>
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

$query_staff_names = "select id, first_name, last_name as last_initial from staff_list order by first_name";
$staff_names = mysql_query($query_staff_names) or die(mysql_error());
$totalRows_staff_names = mysql_num_rows($staff_names);

$query_experiment_names = "select e.id, concat(e.name, ' (', p.name, ')') as name from experiments e, projects p where p.id=e.project_id order by name";
$experiment_names = mysql_query($query_experiment_names) or die(mysql_error());
$totalRows_experiment_names = mysql_num_rows($experiment_names);

$project_names_sql = "select id, name, description from projects";
$project_names = mysql_query($project_names_sql) or die(mysql_error());
$totalRows_project_names = mysql_num_rows($project_names);

$q = "select * from sample_characterizations order by name";
$characterizations = mysql_query($q) or die(mysql_error());
$characterizations_count = mysql_num_rows($characterizations);

$q = "select sl.id, ml.name from mailing_lists ml, staff_list sl where sl.mailing_list_id=ml.id and title=\"Supervisor\" order by name";
$mailing_lists = mysql_query($q) or die(mysql_error());

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Dendreon Analytical Science Sample Submission Form</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

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
	$(function() {
	  var name = $( "#ex_name" ),
		desc = $( "#desc" ),
		goal = $( "#goal" ),
		dept_origin = $( "#dept_origin" ),
		project = $( "#project" ),
		allFields = $( [] ).add( name ).add( desc ).add( goal ).add( dept_origin ).add( project ),
		tips = $( ".validateTips" );
   
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
		height: 590,
		width: 400,
		modal: true,
		buttons: {
		  "Create Experiment": function() {
			var bValid = true;
			allFields.removeClass( "ui-state-error" );
   
			bValid = bValid && checkLength( name, "Experiment Name", 3, 20 );
			bValid = bValid && checkLength( desc, "Experiment Description", 4, 124 );
			bValid = bValid && checkLength( goal, "Experiment Goal", 4, 124 );
			//bValid = bValid && checkLength( password, "password", 5, 16 );
   
			bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_ ])+$/i, "Name may consist of a-z, 0-9, underscores, begin with a letter." );
			bValid = bValid && checkRegexp( dept_origin, /^[0-9]{3}$/i, "Department of Origin must consist of a 3 digit number." );
			// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
			//bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
			//bValid = bValid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
   
			if ( bValid ) {
				$.get("ajax/newExperiment.php", 
				{name: name.val(), description: desc.val(), goal: goal.val(), dept_origin: dept_origin.val(), project_id: project.val()},
				function(data){
					var data1 = eval("(" + data + ")");
				$('#experiment_id')
					 .append($("<option></option>")
					 .attr("value",data1.id)
					 .text(data1.name));
				$('#experiment_id').val(data1.id);
/*				*/});
			  $( this ).dialog( "close" );
			}
		  },
		  Cancel: function() {
			$( this ).dialog( "close" );
		  }
		},
		close: function() {
		  allFields.val( "" ).removeClass( "ui-state-error" );
		}
	  });
   
	  $( "#create-user" )
		.button()
		.click(function() {
		  $( "#dialog-form" ).dialog( "open" );
		});
	});
  </script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div role="content">
        <header>
        	<h1>Dendreon Analytical Sciences</h1>
            <h2>Sample Submission Form</h2>
        </header>
        <script src="js/nav.js"></script>
        <? if (isset($_POST['submit'])){	
		$rt = $_POST['results_type'];
		$rt_str = "";
		  if(!empty($rt)) {
			$rt_str = implode(",",$rt);
  		  }		
			$insertSQL = sprintf("INSERT INTO sampleSets (name, submitted_by, submitted_to, experiment_id, priority, expected_completion_date, storage_temp, store_where, keep_samples, samples_location, comments, matrix_comments, result_type, require_raw_data, provide_spent_media, chromatogram_overlays, information_sought) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['submittedBy'], "text"),
                       GetSQLValueString($_POST['submittedTo'], "text"),
                       GetSQLValueString($_POST['experiment_id'], "int"),
                       GetSQLValueString($_POST['priority'], "int"),
                       GetSQLValueString($_POST['resultsExpected'], "date"),
                       GetSQLValueString($_POST['storageTemp'], "text"),
                       GetSQLValueString($_POST['storeWhere'], "text"),
                       GetSQLValueString($_POST['keepSamples'], "text"),
                       GetSQLValueString($_POST['sampleLocation'], "text"),
                       GetSQLValueString($_POST['anythingElse'], "text"),
                       GetSQLValueString($_POST['typeOfMatrix'], "text"),
                       GetSQLValueString($rt_str, "text"),
                       isset($_POST['rawdata']) ? "1":"0",
                       isset($_POST['spentmedia']) ? "1":"0",
                       isset($_POST['chromatograms']) ? "1":"0",
                       GetSQLValueString($_POST['informationSought'], "text"));
			//echo $insertSQL . "<BR>";		   
			mysql_query($insertSQL) or die('Invalid query: ' . mysql_error());
			
			//get the date for the inserted row
			$new_id_rs = mysql_query('SELECT id FROM  sampleSets ORDER BY id DESC LIMIT 1') or die('Invalid query: ' . mysql_error());
			$new_id_arr = mysql_fetch_assoc($new_id_rs);
			$new_id = $new_id_arr['id'];
			
			$myArr =  json_decode($_POST['tableData']);
			for($i = 0; $i < count($myArr) - 1; $i++) {
				$insertSQL2 = "insert into samples (sampleset_id, sample_id, name, characterization_requested, ph, estimated_concentration) values (" . GetSQLValueString($new_id, "int") . ", " . GetSQLValueString($myArr[$i][1], "text") . ", " . GetSQLValueString($myArr[$i][2], "text") . ", (select id from sample_characterizations where upper(name) = upper(" . GetSQLValueString($myArr[$i][3], "text") . ")), " . GetSQLValueString($myArr[$i][4], "text") . ", " . GetSQLValueString($myArr[$i][5], "text") . ")";
				mysql_query($insertSQL2) or die('Invalid query: ' . mysql_error());
			}
			
			$sql = "select sl.id, first_name, last_name, ml.id as ml_id, name as mailing_list_name, email, title, department " . 
					"from staff_list sl, mailing_lists ml " . 
					"where (sl.id=" . GetSQLValueString($_POST['submittedBy'], "int") . " and ml.id = (select mailing_list_id from staff_list where id=" . GetSQLValueString($_POST['submittedBy'], "int") . ")) or (sl.mailing_list_id = ml.id and ml.id = (select mailing_list_id from staff_list where id=" . GetSQLValueString($_POST['submittedTo'], "text") . "))";
			$userInfo = mysql_query($sql) or die('Invalid query: ' . mysql_error());
			
			$to = "";
			$to_ids = "";
			$to_names = "";
			$analyst = "";
			$group = "";
			$ml_id = "";
			$sb_email = "";
			while($staff_list = mysql_fetch_assoc($userInfo)){
				if($staff_list['id'] == $_POST['submittedBy']){
					$sb_email = $staff_list['email'];
				}else{
					if($to != ""){
						$to_names .= " and ";
						$to .= ", ";
						$to_ids .= ",";
					}
					$to_names .= $staff_list['first_name'];
					$to_ids .= $staff_list['id'];
					$to .= $staff_list['first_name'] . " " . $staff_list['last_name'] . " <" . $staff_list['email'] . ">";

					if($staff_list['id'] == $_POST['submittedTo']){
						$analyst = $staff_list['first_name'] . " " . $staff_list['last_name'];
						$group =  $staff_list['mailing_list_name']. " (" . $staff_list['department'] . ")";
						$ml_id = $staff_list['ml_id'];
					}
				}
			}
			
			$email_text = "";
			if($Global['debug'] == true){ $email_text .= "DEBUG: this email would have been sent to: " . $to . " and cc'd to: " . $sb_email . ".<br><br>";}
			$email_text .= "Dear " . $group . ",<BR><BR>A new sample list has been submitted to your group for analysis.<BR><BR>";
			$email_text .= "Please follow <a href=\"" . $Global['baseurl'] . "dispatch.php?ml_id=" . urlencode($ml_id) . "\">this link</a> to review the submission, then approve or reject it.<BR><BR>";
			$email_text .= "Thank you.<br><br>";
			$email_text .= "This email has been automatically generated by the Dendreon Sample Submission Tracking Application.";
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		//$headers .= 'To: Your Name <you@gmail.com>' . "\r\n"; 	
		$headers .= 'From: DNDN Sample Tracking Application<noreply@dendreon.com>' . "\r\n";
		//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
		//$headers .= 'Reply-To: noreply@dendreon.com' . "\r\n";
		
		if($Global['debug'] == true){
			$to = $Global['debug_to'];;
		}else{
			$headers .= 'Cc: ' . $sb_email . "\r\n";
		}
		mail($to, "New Sample List Submission", $email_text, $headers);
	
			print "<p>Your samples been successfully submitted to the " . $group ." group supervisor for review.</p>";
			print "<p>You will receive an email once the task has been acknowledged.</p>";
			print "<p>Check the status at any time by seeing the Sample Set tracking page <a href=\"sampleSetReview.php?id=" . $new_id . "\">here</a>.</p>";

		}else{
		
		?>
        <!--[if lt IE 8]>
        	<p id="ie8orbelow">To submit a sample set, please use an updated browser!  Internet Explorer 8 and below do not work!</p>
		<![endif]-->
        <p>Please enter the following infomation about your sample set.</p>
        <div id="formErrors" style="color:red; font-weight: bold;"></div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validateFormOnSubmit(this)"  autocomplete="on">
        <table class="coloredRowsTable" cellspacing="0">
        <tr><td>Submitted by:</td><td>
        <select id="submittedBy" name="submittedBy" type="text" style="width: 200px">
        	<option></option>
        	<? while($row_staff_names = mysql_fetch_assoc($staff_names)){ ?>
				<option value="<?= $row_staff_names['id'] ?>"><?= $row_staff_names['first_name'] ?> <?= substr($row_staff_names['last_initial'], 0,1) ?>.</option>
                
			<? } ?>
        	</select>
        </td>
        <td>Results Expected:</td><td class="noSpinner"><input name="resultsExpected" type="date" value="<?= date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+2, date("Y"))) ?>"/></td></tr>
        <tr><td>Submitted to:</td><td><select id="submittedTo" name="submittedTo" type="text" style="width: 200px;">
        	<option></option>
			<? 
			while($mls = mysql_fetch_assoc($mailing_lists)){ ?>
				<option value="<?= $mls['id'] ?>"><?= $mls['name'] ?></option>
                
			<? } ?>
            <option disabled>-------------------</option>
			<? 
			mysql_data_seek($staff_names, 0);
			while($row_staff_names = mysql_fetch_assoc($staff_names)){ ?>
				<option value="<?= $row_staff_names['id'] ?>"><?= $row_staff_names['first_name'] ?> <?= substr($row_staff_names['last_initial'], 0,1) ?>.</option>
                
			<? } ?>
        	</select>
        </td><td></td><td></td></tr>
        
        <tr>
          <td>Give this Sample Set an easy identifier/name:</td>
          <td>
        	<input type="text" id="name" name="name"/></td>      <td nowrap align="right">Priority:<br><small>*1 is high priority, 5 is low priority</small></td>
      	  <td valign="top"><input type="number" name="priority" min="1" max="5" value="3"></td>
		</tr>
        <tr><td>As Part of This Experiment:</td><td>
        	<select name="experiment_id" id="experiment_id">
            	<? while($exp_name = mysql_fetch_assoc($experiment_names)){ ?>
						<option value="<?= $exp_name['id'] ?>"><?= $exp_name['name']?></option>
                                    
            	<? } ?>
            </select></td><td><input type="button" value="New Experiment" id="create-user"/></td><td><p id="result"></p></td></tr>
        <tr><td colspan="2">Location of samples:</td><td colspan="2"><input type="text" name="sampleLocation"  size="45"/></td></tr>
        <tr><td colspan="2">What do you want to know about these samples?</td><td colspan="2"><input type="text" name="informationSought"  size="45"/></td></tr>
        <tr><td colspan="2">Composition of matrix?  </td><td colspan="2"><input type="text" name="typeOfMatrix" size="45"/></td></tr>
        <tr><td colspan="2">Storage Temperature:</td><td colspan="2"><input type="radio" name="storageTemp" value="room temp" checked>Room Temp.</input><br><input type="radio" name="storageTemp" value="4C">4C</input><br><input type="radio" name="storageTemp" value="-20C">-20C</input><br><input type="radio" name="storageTemp" value="-70C">-70C</input></td></tr>
        <tr><td colspan="2">Keep samples when finished?</td><td colspan="2"><input type="radio" name="keepSamples" value="yes">Yes  </input>&nbsp;&nbsp;&nbsp;<input type="radio" name="keepSamples" value="no" checked>No</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If yes, where?  <input type="text" name="storeWhere" size="15"></td></tr>
        <tr><td colspan="2">Do you require</td><td colspan="2"><input type="checkbox" name="chromatograms" value="1" /><label for="chromatograms">Chromatogram Overlays</label><br><input type="checkbox" name="spentmedia" value="1" /><label for="spentmedia">Spent Media</label></td></tr>
        <tr><td colspan="2">Results type desired</td><td colspan="2"><input type="checkbox" name="results_type[]" value="Quantitative"/>Quantitative<br><input type="checkbox" name="results_type[]"  value="Qualitative"/>Qualitative</td></tr>
<!--    <tr><td colspan="2">Please provide spent media containing no PA2024 for standard curves and biosensor blocking.</td><td colspan="2"><textarea name="provideSpentMedia" rows="3" cols="55"></textarea></td></tr>        
		<tr><td colspan="2">(ForteBio only)<br>What are the theorized concentrations of your samples?  Rough estimate of concentrations needed to dilute samples within assay's working range.</td><td colspan="2"><input type="text" name="theorizedConcentrations" /></td></tr>-->
        <td colspan="2">Submitter's Notes:</td><td colspan="2"><textarea name="anythingElse" rows="3" cols="55"></textarea></td></tr>
       </table><br>
        <div id="handsomeTable" ></div>Paste your sample data in the table above.
<!-- was:   <tr><td colspan="4" align="center"><iframe width='500' height='300' frameborder='0' src='https://docs.google.com/spreadsheet/pub?key=0AmgCK-PPH8sidFRrb3JlclhqNEQtRm9QYVluRFJfV2c&output=html&widget=true'></iframe></td></tr> -->
        <center><input type="hidden" name="tableData" id="tableData"><input name="submit" Value="Submit Samples" class="ui-button ui-widget ui-state-default ui-corner-all" type="submit" onClick="$('#tableData').val($('#handsomeTable').data('handsomeTable').getData().stringify());"></center>
        
        </form>
        <? } ?>
        <p>&nbsp;</p>
		</div>
        <script>
		
		var selectBoxRenderer = function (instance, td, row, col, prop, value, cellProperties) {
			//  conditions for now           
			if (td.innerHTML === undefined || td.innerHTML === null || td.innerHTML === "") {
			// test selectbox
			var selectbox = " <select id=" + 'statusselection' + row + " style=" + 'width:100%;' + " ><option>Ontwikkel Inkoop</option><option>Niet assortiment</option><option>Ontwikkel Verkoop</option><option selected=" + 'selected' + ">Voorraad</option><option>Uitloop</option></select>";
			var $td = $(td);
			var $text = $(selectbox);
			$text.on('mousedown', function (event) {
                      event.stopPropagation(); //prevent selection quirk
                    });

            $td.empty().append($text);
            $('#statusselection' + row).change(function () {
                var value = this[this.selectedIndex].value;
                instance.setDataAtCell(row, prop, value);
            });
			}
		};

        var selectBoxEditor = function (instance, td, row, col, prop, keyboardProxy, cellProperties) {
			// none at this time
        };
		         var data = [			
              ["one", "two", "three", "four", "Five"],["six", "seven", "eight", "nine", "ten"]
            ];

			var container = $("#handsomeTable");
            container.handsontable({
             // data: data,
              startRows: 8,
              startCols: 5,
			  rowHeaders: true,
  			  colHeaders: ['Sample Number', 'Sample Name', 'Requested Characterization', 'ph', 'Est. Conc.'],
			  minSpareCols: 0,
			  minSpareRows: 1,
              currentRowClassName: 'currentRow',
              currentColClassName: 'currentCol',
			  contextMenu: true,
			  columns: [
			  		{data: 1, type: 'text'},
			  		{data: 2, type: 'text'},
					{
						data: 3, 
					  type: 'autocomplete',
					  source: [ <? $i = 0; while($a = mysql_fetch_assoc($characterizations)){
						  						if($i++ > 0){echo ", ";}
						  						echo "\"" . $a['name'] . "\"";
					  						} ?>
						  		],
						strict: true,
					  options: {
						items: <?= $characterizations_count ?> //`options` overrides `defaults` defined in bootstrap typeahead
					  }
					},
			  		{data: 4, type: 'text'},
			  		{data: 5, type: 'text'}
			  		//{data: 7, type: 'checkbox'}
				]
            });

		function firstRenderer(instance, td, row, col, prop, value, cellProperties) {
		  Handsontable.TextCell.renderer.apply(this, arguments);
		}
			
          </script>
          
          <!-- form validation: -->
          <script>
		  function postJSONObj(){
		  }
		  function validateFormOnSubmit(theForm) {
				var reason = "";
				$('#formErrors').empty();
			    $('#tableData').val(JSON.stringify(container.handsontable('getData')));//json_encode());
				if(container.handsontable('getData').length == 1){
					reason += "You must submit at least 1 sample with this sample set.<br>";
				}
				  reason += validateNameField(theForm.name, "You entered an invalid value for \"Name\" field.<br>");
//				  reason += validateNameField(theForm.submittedTo, "You entered an invalid name for \"Submitted To\".<br>");
//				  reason += validatePassword(theForm.pwd);
//				  reason += validateEmail(theForm.email);
//				  reason += validatePhone(theForm.phone);
				  reason += validateEmpty(theForm.submittedBy, "Please fill out 'Submitted By' field.<br>");
				  reason += validateEmpty(theForm.submittedTo, "Please fill out 'Submitted To' field.<br>");
					  
				  if (reason != "") {
					$('#formErrors').append("Some fields need correction:<br>" + reason);
					window.scrollTo(100, 0);
					return false;
				  }
				
				  return true;
			}
				
			function validateNameField(fld, msg) {
				var error = "";
				var illegalChars = /\W/; // allow letters, numbers, and underscores
			 
				if (fld.value == "") {
					fld.style.background = 'Yellow'; 
					error = msg;
				} else if ((fld.value.length < 3)){//|| (fld.value.length > 35)) {
					fld.style.background = 'Yellow'; 
					error = msg + " -It must be longer than 3 characters.<br>\n";
				} /*else if (illegalChars.test(fld.value)) {
					fld.style.background = 'Yellow'; 
					error = "The highlighted field contains illegal characters.\n";
				} */
				else {
					fld.style.background = 'White';
				} 
				return error;
			}
			function validateEmpty(fld, msg) {
				var error = "";
				var illegalChars = /\W/; // allow letters, numbers, and underscores
			 
				if (fld.value == "") {
					fld.style.background = 'Yellow'; 
					error = msg;
				} else {
					fld.style.background = 'White';
				} 
				return error;
			}
</script>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div id="dialog-form" title="Create New Experiment">
  		<p class="validateTips">All form fields are required.</p>
          <form>
          <fieldset>
            <label for="name">Experiment Name:</label><br>
            <input type="text" name="ex_name" id="ex_name" class="text ui-widget-content ui-corner-all" /><br><br>
            <label for="project">Belonging to Project:</label> &nbsp;&nbsp;&nbsp;
            <select name="project" id="project" class="text ui-widget-content ui-corner-all" >
            	<? while($pn = mysql_fetch_assoc($project_names)){ ?>
                	<option value="<?= $pn['id'] ?>"><?= $pn['name'] ?></option>
                <? } ?>
            </select><br><br>
            <label for="desc">Description:</label><br>
            <textarea name="desc" id="desc"  class="text ui-widget-content ui-corner-all" ></textarea><br><br>
            <label for="desc">Goal of the Experiment:</label><br>
            <textarea name="goal" id="goal"  class="text ui-widget-content ui-corner-all" ></textarea><br><br>
            <label for="name">Department of Origin:</label>
            <input type="text" name="dept_origin" id="dept_origin" style="width: 40px" class="text ui-widget-content ui-corner-all" />
          </fieldset>
          </form>
        </div>
        <footer>
        	&nbsp;
        </footer>
    </body>
</html>   
<?php
mysql_free_result($staff_names);
mysql_free_result($project_names);
mysql_free_result($experiment_names);
mysql_free_result($characterizations);
mysql_free_result($mailing_lists);
?>

<? $id = $_GET['id']; 
	$type = $_GET['type']; 
	$spl_name = urldecode($_GET['name']);
	$group = $_GET['group'];  
	$reason = "";
	if(isset($_GET['reason'])){ $reason = $_GET['reason'];}  
	$submitted_to = $_GET['st'];
	$submitted_by = $_GET['sb'];
	$og_submitted_to = $_GET['original_submitted_to'];
	//echo "id: " . $id . " <br>reason:" . $reason . " <br>sub_to:" . $submitted_to . " <br>og_st:" . $og_submitted_to;
if($id == "" or $type == "" or $submitted_to == "" or $og_submitted_to == ""){
	echo "error";
}else {
		require_once('../admin/config/global.php');
		$email_text = "";
		
		$sql = "select * from staff_list where id=" . $submitted_by;
		$sb_user_q = mysql_query($sql) or die(mysql_error());
		$sb_user = mysql_fetch_assoc($sb_user_q);
		
		$sql = "select id, first_name, email, title from staff_list where mailing_list_id=(select mailing_list_id from staff_list where id=" . $submitted_to . ")";
		$supervisor_q = mysql_query($sql) or die(mysql_error());
		$supervisor = "";
		$st_name ="";
		$ost_name = "";
		$supervisor_email = "";
		$st_email ="";
		$ost_email = "";
		$email_subject = "";
		$to = "";
		$i=0;
		
		while($user = mysql_fetch_assoc($supervisor_q)){
			if($user['title'] == "Supervisor"){
				if($i++ > 0){
					$supervisor .= " or ";
					$supervisor_email .= ",";
				}
				$supervisor .= $user['first_name'];
				$supervisor_email .= $user['email'];
			}
			if($user['id'] == $og_submitted_to){
				$ost_name = $user['first_name'];
				$ost_email = $user['email'];
			}
			if($user['id'] == $submitted_to){
				$st_name = $user['first_name'];
				$st_email = $user['email'];
			}
		}
		
		//prepare email headers:
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		//$headers .= 'To: Hector Ramos <ramoshf@gmail.com>' . "\r\n"; 	
		$headers .= 'From: DNDN Sample Tracking Application<noreply@dendreon.com>' . "\r\n";
		//$headers .= 'Cc: ' . $supervisor_email . ',' . $ost_name_email . "\r\n";
		$headers .= 'Reply-To: noreply@dendreon.com' . "\r\n";
		
		$to = $sb_user['email'] . ", " . $supervisor_email . ", " . $st_email;
		if($st_email != $ost_email){ $to .= ", " . $ost_email;}
		
	if($type == "reject"){
		$sql = "update sampleSets set status=(select id from statuses where status=\"Rejected\"), comments = CONCAT(comments, \"\n\nREJECTED: \", \"" . $reason . "\") where id=" . $id;
		mysql_query($sql) or die (mysql_error());
		
					
		$email_text .= "Dear " . $sb_user['first_name'] . ",<BR><BR>Your sample set list entitled \"" . $spl_name . "\" which you recently submitted to " . $ost_name . " has been REJECTED by the " . $group . " group.<BR><BR>";
		$email_text .= "The reason given was: " . $reason . "<br><br>";
		$email_text .= "Please contact " . $supervisor['first_name'] . " if you have any futher questions.<br><br>";
		$email_text .= "Thank you.<br><br><br>";
		$email_text .= "This email has been automatically generated by the Dendreon Sample Submission Tracking Application.";
		
		$email_subject = "REJECTED - Sample List Submission";
		echo "<p>The sample set list named \"" . $spl_name . "\" has been rejected and the submitter has been notified.</p>";
		
	}else if($type == "accept"){
		$sql = "update sampleSets set status=(select id from statuses where status=\"Accepted\"), analyzed_by=" . $submitted_to . " where id=" . $id;
		mysql_query($sql) or die (mysql_error());
							
		$email_text .= "Dear " . $sb_user['first_name'] . ",<BR><BR>Your sample set list entitled \"" . $spl_name . "\" which you recently submitted has been ACCEPTED by the " . $group . " group and assigned to the analyst " . $st_name . ".<BR><BR>";
		$email_text .= "Please contact " . $supervisor . " if you have any questions.<br><br>";
		$email_text .= "Thank you.<br><br><br>";
		$email_text .= "This email has been automatically generated by the Dendreon Sample Submission Tracking Application.";
		$to = $sb_user['email'];
		
		$email_text2 = "Dear " . $st_name . ",<BR><BR>The sample set list entitled \"" . $spl_name . "\" which was recently submitted by " . $sb_user['first_name'] . " has been ACCEPTED by your group, the " . $group . " group, and assigned to you for analysis.<BR><BR>";
		$email_text2 .= "Please follow <a href=\"". $Global['baseurl']. "analysis.php?id=" . $id . "\">this link</a> when you are ready to commence the analysis.<br><br>";
		$email_text2 .= "Thank you.<br><br><br>";
		$email_text2 .= "This email has been automatically generated by the Dendreon Sample Submission Tracking Application.";
		$to2 = $st_email . ", " . $supervisor_email;
		$email_subject = "ACCEPTED - Sample List Submission";
		
		echo "<p>The sample set list named \"" . $spl_name . "\" has been accepted for analysis by " . $st_name . " and the submitter has been notified.</p>";
		if($Global['debug'] == true){$email_text2 .= "<BR><BR>DEBUG: this email was going to be sent to: " . $to2; $to2 = $Global['debug_to'];}
		mail($to2, $email_subject, $email_text2, $headers);
	}
	
	if($Global['debug'] == true){$email_text .= "<BR><BR>DEBUG: this email was going to be sent to: " . $to; $to = $Global['debug_to'];}
	mail($to, $email_subject, $email_text, $headers);

	mysql_free_result($sb_user_q);
	mysql_free_result($supervisor_q);
}
?>
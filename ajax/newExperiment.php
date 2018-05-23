<? $name = $_GET['name']; 
	$desc = $_GET['description']; 
	$goal = $_GET['goal']; 
	$dept_origin = $_GET['dept_origin']; 
	$project_id = $_GET['project_id']; 
	//echo $name . " " . $desc . " " . $project_id . " ";
if($name == "" or $desc == "" or $project_id == "" or $goal == "" or $dept_origin == ""){
	echo "error";
}else{
	require_once('../admin/config/global.php');
	$sql = "insert into experiments (name, description, goal, department_origin, project_id) values ('" . $name . "', '" . $desc . "', '" . $goal . "', '" . $dept_origin . "', " . $project_id . ")";
	mysql_query($sql);
	$tmp = mysql_query("select e.id, concat(e.name, ' (', p.name, ')') as name from experiments e, projects p where e.project_id=p.id order by e.id desc limit 1");
	$tmp2 = mysql_fetch_assoc($tmp);
	echo "{\"id\" : " . $tmp2['id'] . ", \"name\": \"" . $tmp2['name'] . "\"}";
}
?>
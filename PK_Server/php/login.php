<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "kemijarvi";

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if(isset($_GET['server']) && isset($_GET['name']) && isset($_GET['pass'])){
	$output_result = new stdClass();
	$output_result->done = false;
	$input_server = $_GET['server'];
	$input_name = $_GET['name'];
	$input_pass = $_GET['pass'];
	$query_0 = "SELECT id FROM auth_data WHERE server = '$input_server' AND name = '$input_name' AND pass = '$input_pass' ";
	if ($stmt_0 = $mysqli->prepare($query_0)) {
		$stmt_0->execute();
		$stmt_0->store_result();
		$stmt_0->bind_result($return_id);
		$stmt_0->fetch();
		if($stmt_0->num_rows == 1){
			$output_result->id = $return_id;
			$output_result->done = true;
		}
		$stmt_0->close();
	}
}
$mysqli->close();

echo json_encode($output_result);

?>
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

if(isset($_GET['hand']) && isset($_GET['id'])){
	$output_result = new stdClass();
	$output_result->done = false;
	$input_hand = $_GET['hand'];
	$input_id = $_GET['id'];
	if($input_hand == "pull"){
		$query_0 = "SELECT crd FROM auth_data WHERE id = '$input_id' ";
		if ($stmt_0 = $mysqli->prepare($query_0)) {
			$stmt_0->execute();
			$stmt_0->bind_result($return_crd);
			$stmt_0->fetch();
			$output_result->done = true;
			$output_result->crd = $return_crd;
			$stmt_0->close();
		}
	}
	else if($input_hand == "push"){
		$input_crd = $_GET['crd'];
		$query_0 = "UPDATE auth_data SET crd = '$input_crd' WHERE id = '$input_id' ";
		if ($stmt_0 = $mysqli->prepare($query_0)) {
			$stmt_0->execute();
			$output_result->done = true;
			$stmt_0->close();
		}
	}
}
$mysqli->close();

echo json_encode($output_result);

?>
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
	
	$query_0 = "SELECT * FROM auth_data WHERE id = '$input_id' ";
	if ($stmt_0 = $mysqli->prepare($query_0)) {
			$stmt_0->execute();
			$stmt_0->store_result();
			if($stmt_0->num_rows != 1){
				$output_result->done = false;
				$stmt_0->close();
				$mysqli->close();
				exit();
			}
	}
	if($input_hand == "server"){
		$input_server = $_GET['server'];
		$query_1 = "UPDATE auth_data SET server = '$input_server' WHERE id = '$input_id' ";
		if ($stmt_1 = $mysqli->prepare($query_1)) {
			$stmt_1->execute();
			$output_result->done = true;
			$stmt_1->close();
		}
	}
	else if($input_hand == "name"){
		$input_name = $_GET['name'];
		$query_1 = "UPDATE auth_data SET name = '$input_name' WHERE id = '$input_id' ";
		if ($stmt_1 = $mysqli->prepare($query_1)) {
			$stmt_1->execute();
			$output_result->done = true;
			$stmt_1->close();
		}
	}
	else if($input_hand == "pass"){
		$input_pass = $_GET['pass'];
		$query_1 = "UPDATE auth_data SET pass = '$input_pass' WHERE id = '$input_id' ";
		if ($stmt_1 = $mysqli->prepare($query_1)) {
			$stmt_1->execute();
			$output_result->done = true;
			$stmt_1->close();
		}
	}
	else if($input_hand == "crd"){
		$input_crd = $_GET['crd'];
		$query_1 = "UPDATE auth_data SET crd = '$input_crd' WHERE id = '$input_id' ";
		if ($stmt_1 = $mysqli->prepare($query_1)) {
			$stmt_1->execute();
			$output_result->done = true;
			$stmt_1->close();
		}
	}
}
$mysqli->close();

echo json_encode($output_result);

?>
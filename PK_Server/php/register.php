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
	$query_0 = "SELECT id FROM auth_data WHERE server = '$input_server' AND name = '$input_name' ";
	if ($stmt_0 = $mysqli->prepare($query_0)) {
		$stmt_0->execute();
		$stmt_0->store_result();
		if($stmt_0->num_rows != 0){
				$output_result->done = false;
		} else {
			generate_id:
			$generated_id = $input_server.
			"-".str_pad(rand(0,999), 3, '0', STR_PAD_LEFT).
			"-".str_pad(rand(0,999), 3, '0', STR_PAD_LEFT).
			"-".str_pad(rand(0,999), 3, '0', STR_PAD_LEFT).
			"-".str_pad(rand(0,999), 3, '0', STR_PAD_LEFT);
			$query_1 = "SELECT server FROM auth_data WHERE id = '$generated_id'";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$stmt_1->store_result();
				if ($stmt_1->num_rows != 0) {
					goto generate_id;
				}
			}
			$query_2 = "INSERT INTO auth_data ( name, pass, server, id ) VALUES ('$input_name', '$input_pass', '$input_server', '$generated_id' ) ";
			if ($stmt_2 = $mysqli->prepare($query_2)) {
				$stmt_2->execute();
				$output_result->done = true;
				$stmt_2->close();
			}
		}
		$stmt_0->close();
	}
}
$mysqli->close();

echo json_encode($output_result);

?>
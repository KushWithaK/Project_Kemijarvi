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

if (isset($_GET['hand'])){
	$input_hand = $_GET['hand'];
	$output_result = new stdClass();
	$output_result->done = false;
	if ($input_hand == "push"){
		$input_id = $_GET['id'];
		$input_trg = $_GET['trg'];
		$input_date = $_GET['date'];
		$input_time = $_GET['time'];
		$input_tsmp = $input_date . " " . $input_time;
		$input_dur = $_GET['dur'];
		$query_0 = "SELECT ckee FROM pack_data WHERE trg = '$input_trg' AND id = '$input_id' AND tsmp = '$input_tsmp' ";
		if ($stmt_0 = $mysqli->prepare($query_0)) {
			$stmt_0->execute();
			$stmt_0->store_result();
			if ($stmt_0->num_rows != 0) {
				$stmt_0->close();
				$mysqli->close();
				exit();
			}
			$query_1 = "SELECT ckee FROM pack_data WHERE dur > 0 ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$stmt_1->store_result();
			}
			$generated_ckee = $stmt_1->num_rows;
			GenerateCkee:
			$query_2 = "SELECT * FROM pack_data WHERE ckee = '$generated_ckee' ";
			if ($stmt_2 = $mysqli->prepare($query_0)) {
				$stmt_2->execute();
				$stmt_2->store_result();
				if ($stmt_2->num_rows != 0) {
					$generated_ckee++;
					goto GenerateCkee;
				} else {
					$output_result->done = false;
				}
				$query_3 = "INSERT INTO pack_data ( id, trg, tsmp, ckee, dur ) VALUES ('$input_id', '$input_trg', '$input_tsmp', '$generated_ckee', '$input_dur' ) ";
				if ($stmt_3 = $mysqli->prepare($query_3)) {
					$stmt_3->execute();
					$output_result->done = true;
				}
			}
		}
	} else if ($input_hand == "pull") {
		if (isset($_GET['id'])){
			$input_id = $_GET['id'];
			$query_1 = "SELECT trg, tsmp, ckee, dur FROM pack_data WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$stmt_1->store_result();
				$stmt_1->bind_result($return_trg, $return_tsmp, $return_ckee, $return_dur);
				$stmt_1->fetch();
				$output_result->num = $stmt_1->num_rows;
				if ($stmt_1->num_rows != 0) {
					$output_result->done = true;
					FOR ($i = 0;$i < $stmt_1->num_rows;$i++){
						$output_result->$i['trg'] = $return_trg;
						$output_result->$i['tsmp'] = $return_tsmp;
						$output_result->$i['ckee'] = $return_ckee;
						$output_result->$i['dur'] = $return_dur;
					}
				} else {
					$output_result->done = false;
				}
			}
		} else if (isset($_GET['trg'])){
			$input_trg = $_GET['trg'];
			$query_1 = "SELECT id, tsmp, ckee, dur FROM pack_data WHERE trg = '$input_trg' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$stmt_1->store_result();
				$stmt_1->bind_result($return_id, $return_tsmp, $return_ckee, $return_dur);
				$stmt_1->fetch();
				$output_number = $stmt_1->num_rows;
				$output_result->num = $output_number;
				if ($stmt_1->num_rows != 0) {
					$output_result->done = true;
					FOR ($i = 0;$i < $stmt_1->num_rows;$i++){
						$output_result->$i['id'] = $return_id;
						$output_result->$i['tsmp'] = $return_tsmp;
						$output_result->$i['ckee'] = $return_ckee;
						$output_result->$i['dur'] = $return_dur;
					}
				} else {
					$output_result->done = false;
				}
			}
		} else if (isset($_GET['ckee'])){
			$input_ckee = $_GET['ckee'];
			$query_1 = "SELECT id, trg, tsmp, dur FROM pack_data WHERE ckee = '$input_ckee' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$stmt_1->store_result();
				$stmt_1->bind_result($return_id, $return_trg, $return_tsmp, $return_dur);
				$stmt_1->fetch();
				$output_number = $stmt_1->num_rows;
				$output_result->num = $output_number;
				if ($stmt_1->num_rows != 0) {
					$output_result->done = true;
					FOR ($i = 0;$i < $stmt_1->num_rows;$i++){
						$output_result->$i['id'] = $return_id;
						$output_result->$i['trg'] = $return_trg;
						$output_result->$i['tsmp'] = $return_tsmp;
						$output_result->$i['dur'] = $return_dur;
					}
				} else {
					$output_result->done = false;
				}
			}
		}
	} else if ($input_hand == "send") {
		if (isset($_GET['ckee']) && isset($_GET['ntw'])){
			$input_ckee = $_GET['ckee'];
			$input_ntw = $_GET['ntw'];
			$query_0 = "SELECT tsmp FROM pack_data WHERE ckee = '$input_ckee' AND dur > 0 ";
			if ($stmt_0 = $mysqli->prepare($query_0)) {
				$stmt_0->execute();
				$stmt_0->store_result();
				if ($stmt_0->num_rows != 1) {
					$stmt_0->close();
					$mysqli->close();
					exit();
				}
				$query_1 = "UPDATE pack_data SET ntw = '$input_ntw' WHERE ckee = '$input_ckee' ";
				if ($stmt_1 = $mysqli->prepare($query_1)) {
					$stmt_1->execute();
					$output_result->done = true;
				}
			}
		}
	} else if ($input_hand == "read") {
		if (isset($_GET['ckee'])){
			$input_ckee = $_GET['ckee'];
			$query_0 = "SELECT ntw FROM pack_data WHERE ckee = '$input_ckee' AND dur > 0 ";
			if ($stmt_0 = $mysqli->prepare($query_0)) {
				$stmt_0->execute();
				$stmt_0->store_result();
				$stmt_0->bind_result($return_ntw);
				$stmt_0->fetch();
				if ($stmt_0->num_rows != 1) {
					$stmt_0->close();
					$mysqli->close();
					exit();
				}
				$output_result->ntw = $return_ntw;
				$output_result->done = true;
			}
		}
	}
}
$mysqli->close();

echo json_encode($output_result);

?>
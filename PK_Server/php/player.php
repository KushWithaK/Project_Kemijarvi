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
	if($input_hand == "create" && isset($_GET['name'])){
		$input_name = $_GET['name'];
		$query_0 = "SELECT name FROM user_data WHERE id = '$input_id' ";
		if ($stmt_0 = $mysqli->prepare($query_0)) {
			$stmt_0->execute();
			$stmt_0->store_result();
			if($stmt_0->num_rows != 0){
				$output_result->done = false;
				$stmt_0->close();
				$mysqli->close();
				exit();
			}
			$query_1 = "INSERT INTO user_data ( name, id ) VALUES ('$input_name', '$input_id' ) ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
	} else if($input_hand == "delete"){
		$query_0 = "SELECT name FROM user_data WHERE id = '$input_id' ";
		if ($stmt_0 = $mysqli->prepare($query_0)) {
			$stmt_0->execute();
			$stmt_0->store_result();
			if($stmt_0->num_rows != 1){
				$output_result->done = false;
				$stmt_0->close();
				$mysqli->close();
				exit();
			}
			$query_1 = "DELETE FROM user_data WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
	} else if(($input_hand == "quick") && isset($_GET['lvl'])) && isset($_GET['name'])){
		$input_name = $_GET['name'];
		$input_lvl = $_GET['lvl'];
		$query_0 = "SELECT name FROM user_data WHERE id = '$input_id' ";
		if ($stmt_0 = $mysqli->prepare($query_0)) {
			$stmt_0->execute();
			$stmt_0->store_result();
			if($stmt_0->num_rows != 0){
				$output_result->done = false;
				$stmt_0->close();
				$mysqli->close();
				exit();
			}
			$query_1 = "INSERT INTO user_data ( name, id, lvl ) VALUES ('$input_name', '$input_id', '$input_lvl' ) ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
	} else if(($input_hand == "pull")){
		$query_0 = "SELECT 
			name, lvl, xp, hp_m, hp_c, ep_m, ep_c, loc_x, loc_y, loc_z, rot_x, rot_y, rot_z, sca_x, sca_y, sca_z 
			FROM user_data WHERE id = '$input_id' ";
		if ($stmt_0 = $mysqli->prepare($query_0)) {
			$stmt_0->execute();
			$stmt_0->bind_result(
				$return_name, $return_lvl, $return_xp, $return_hpm, $return_hpc $return_epm, $return_epc, 
				$return_locx, $return_locy, $return_locz, 
				$return_rotx, $return_roty, $return_rotz
				$return_scax, $return_scay, $return_scaz);
			$stmt_0->fetch();
			$stmt_0->store_result();
			if($stmt_0->num_rows != 0){
				$output_result->done = false;
				$stmt_0->close();
				$mysqli->close();
				exit();
			} else {
				$output_result->name = $return_name;
				$output_result->lvl = $return_lvl;
				$output_result->xp = $return_xp;
				$output_result->hp_m = $return_hpm;
				$output_result->hp_c = $return_hpc;
				$output_result->ep_m = $return_epm;
				$output_result->ep_c = $return_epc;
				$output_result->loc_x = $return_locx;
				$output_result->loc_y = $return_locy;
				$output_result->loc_z = $return_locz;
				$output_result->rot_x = $return_rotx;
				$output_result->rot_y = $return_roty;
				$output_result->rot_z = $return_rotz;
				$output_result->sca_x = $return_scax;
				$output_result->sca_y = $return_scay;
				$output_result->sca_z = $return_scaz;
			}
		}
	} else if(($input_hand == "push")){
		$query_0 = "SELECT * FROM user_data WHERE id = '$input_id' ";
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
		if(isset($_GET['name'])){
			$input_name = $_GET['name'];
			$query_1 = "UPDATE user_data SET name = '$input_name' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['lvl'])){
			$input_lvl = $_GET['lvl'];
			$query_1 = "UPDATE user_data SET lvl = '$input_lvl' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['xp'])){
			$input_xp = $_GET['xp'];
			$query_1 = "UPDATE user_data SET xp = '$input_xp' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['hp_m'])){
			$input_hpm = $_GET['hp_m'];
			$query_1 = "UPDATE user_data SET hp_m = '$input_hpm' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['hp_c'])){
			$input_hpc = $_GET['hp_c'];
			$query_1 = "UPDATE user_data SET hp_c = '$input_hpc' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['ep_m'])){
			$input_epm = $_GET['ep_m'];
			$query_1 = "UPDATE user_data SET ep_m = '$input_epm' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['ep_c'])){
			$input_epc = $_GET['ep_c'];
			$query_1 = "UPDATE user_data SET ep_c = '$input_epc' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['loc_x'])){
			$input_locx = $_GET['loc_x'];
			$input_locy = $_GET['loc_y'];
			$input_locz = $_GET['loc_z'];
			$query_1 = "UPDATE user_data SET loc_x = '$input_locx', loc_y = '$input_locy', loc_z = '$input_locz' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['rot_x'])){
			$input_rotx = $_GET['rot_x'];
			$input_roty = $_GET['rot_y'];
			$input_rotz = $_GET['rot_z'];
			$query_1 = "UPDATE user_data SET rot_x = '$input_rotx', rot_y = '$input_roty', rot_z = '$input_rotz' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
		if(isset($_GET['sca_x'])){
			$input_scax = $_GET['sca_x'];
			$input_scay = $_GET['sca_y'];
			$input_scaz = $_GET['sca_z'];
			$query_1 = "UPDATE user_data SET sca_x = '$input_scax', sca_y = '$input_scay', sca_z = '$input_scaz' WHERE id = '$input_id' ";
			if ($stmt_1 = $mysqli->prepare($query_1)) {
				$stmt_1->execute();
				$output_result->done = true;
				$stmt_1->close();
			}
		}
	}
}
$mysqli->close();

echo json_encode($output_result);

?>
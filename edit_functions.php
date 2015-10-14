<?php
	
	//edit_functions.php
	// Loon AB'i ühenduse
	require_once("../configGlobal.php");
	$database = "if15_toomloo_3";
	
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT number_plate, color FROM car_plates WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($number_plate, $color);
		$stmt->execute();
		
		$car = new StdClass();
		
		// kas sain ühe rea andmeid kätte
		// $stmt->fetch annab ühe rea andmeid
		if($stmt->fetch()){
			
			//sain
			$car->number_plate = $number_plate;
			$car->color = $color;
			
			
			
		}else{
			
			//ei saanud
			//id'd ei olnud olemas
			//rida on kustutatud, deleted ei ole NULL
			header("Location: table.php");
			
		}
		
		return $car;
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function updateCar($id, $number_plate, $color){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
	}


?>
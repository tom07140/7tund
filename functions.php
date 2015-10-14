<?php
	// functions.php
	// siia tulevd funktsioonid, k�ik mis seotud AB'ga
	
	// Loon AB'i �henduse
	require_once("../configGlobal.php");
	$database = "if15_toomloo_3";
	
	
	// annan vaikev��rtuse
	function getCarData($keyword=""){
		
		$search = "%%";
		
		//kas otsis�na on t�hi
		if($keyword == ""){
			
			//ei otsi midagi
			echo "Ei otsi";
			
		}else{
			
			//otsin
			echo "Otsin ".$keyword;
			$search = "%".$keyword."%";
			
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color FROM car_plates WHERE deleted IS NULL AND (number_plate LIKE ? OR color LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $number_plate, $color);
		$stmt->execute();
		
		// tekitan t�hja massiivi, kus edaspidi hoian objekte
		$car_array= array();
		
		// tee midagi seni, kuni saame ab'st �he rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse nii mitu korda kuni on ridu
			
			//tekitan objekti, kus hakkan hoidma v��rtusi
			$car = new StdClass();
			$car->id = $id;
			$car->plate = $number_plate;
			$car->color = $color;
			$car->user_id = $user_id_from_database;
			
			// lisan massiivi �he rea juurde
			array_push($car_array, $car);
			// var_dump �tleb muutuja nime ja stuffi
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		// tagastan massiivi, kus k�ik read sees
		return $car_array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteCar($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea t�hjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	function updateCar($id, $number_plate, $color){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea t�hjaks
			//header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	

	
	
	
?>
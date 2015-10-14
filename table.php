<?php
	
	require_once("functions.php");
	
	// kas kustutame
	// ?delete=vastav id mida kustutame on aadressireal
	if(isset($_GET["delete"])){
		
		echo "kustutame id ".$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id
		deleteCar($_GET["delete"]);
		
	}
	
	// salvestan muudatuse andmebaasi
	if(isset($_POST["save"])){
		
		updateCar($_POST["id"], $_POST["number_plate"], $_POST["color"]);
		
	}

	// käivitan funktsiooni
	$array_of_cars = getCarData();
	
	// trükin välja esimese auto
	//echo $array_of_cars[1]->id." ".$array_of_cars[1]->plate;

?>

<h2>Tabel</h2>
<table border=1>
	<tr>
		<th>id</th>
		<th>numbrimärk</th>
		<th>värv</th>
		<th>user_id</th>
		<th>kustuta</th>
		<th>edit</th>
	</tr>
	
	<?php
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0;$i < count($array_of_cars);$i++){
			//echo $array_of_cars[$i]->id;
			
			// kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $array_of_cars[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_cars[$i]->id."'>";
				echo "<td>".$array_of_cars[$i]->id."</td>";
				echo "<td><input name='number_plate' value='".$array_of_cars[$i]->plate."'></td>";
				echo "<td><input name='color' value='".$array_of_cars[$i]->color."'></td>";
				echo "<td>".$array_of_cars[$i]->user_id."</td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
				
			}else{
				echo "<tr>";
				echo "<td>".$array_of_cars[$i]->id."</td>";
				echo "<td>".$array_of_cars[$i]->plate."</td>";
				echo "<td>".$array_of_cars[$i]->color."</td>";
				echo "<td>".$array_of_cars[$i]->user_id."</td>";
				echo "<td><a href='?delete=".$array_of_cars[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_cars[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$array_of_cars[$i]->id."'>edit</a></td>";
				echo "</tr>";
				
				
			}
			
		
		}
	
	
	?>

</table>
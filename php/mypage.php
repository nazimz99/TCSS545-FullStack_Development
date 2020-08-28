
	<?php
		require_once("connect.php");
	
		$State = $_POST["state"];
		$sql = "SELECT * 
				FROM Nation
				WHERE State = '".$State."'";
		$result = mysqli_query($db, $sql);
	
		if (empty($State) or mysqli_num_rows($result)==0) {
			echo "Please enter a valid state.";
		}else{
			echo'<table border="10" 
	   			align="center" 
	   			cellspacing="10" 
	   			bordercolor="#0A7E71"
	   			aria-dropeffect="popup"
	   			cols="5"
	   			title="Nation Table About The COVID19 Per State Reported">
				<tr align="center">
				<th> State </th>
				<th> Total Number Of Cases </th>
				<th> Total Number of Deaths </th>
				<th> Total Number of Tests </th>
    			</tr>';
			
			while ($row = mysqli_fetch_assoc($result)) {
			echo '<tr align="center">
				<td>'.$row['State'].'</td>
				<td>'.$row['TotalCases'].'</td>
				<td>'.$row['TotalDeaths'].'</td>
				<td>'.$row['TotalDeaths'].'</td>
				</tr> ';
		}
			
			echo'</table>';
		}
		
		mysqli_close($db); 
	?>

<table border="10" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="5"
	   title="Nation Table About The COVID19 Per State Reported"
	   >
	<tr>
		<th> State </th>
		<th> Initial Rate of Daily Cases </th>
		<th> Current Rate of Daily Cases </th>
    </tr>
	<?php
		require_once("connect.php");
	
		$sql = "SELECT * 
				FROM Infectionrate";
		$result = mysqli_query($db, $sql);
		
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<tr align="center">
					<td>'.$row['State'].'</td>
					<td>'.$row['StartRate'].'</td>
					<td>'.$row['EndRate'].'</td>
					</tr> ';

		}
		mysqli_close($db) 
	?>
</table>
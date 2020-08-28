<table border="5" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="5"
	   title="Nation Table About The COVID19 Per State Reported"
	   >
	<tr>
		<th> State </th>
		<th> Ratio Between Tests And Cases </th>
		<th> Ratio Between Deaths And Cases </th>
	</tr>
	<?php
		require_once("connect.php");
		
		$sql = "SELECT * 
				FROM Ratio";
		$result = mysqli_query($db, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			
			echo '<tr align="center">
				<td>'.$row['State'].'</td>
				<td>'.$row['TestRatio'].'</td>
				<td>'.$row['DeathRatio'].'</td>
				</tr> ';
			
		}
		mysqli_close($db) 
	?>
</table>


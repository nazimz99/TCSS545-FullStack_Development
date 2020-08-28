<table border="10" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="5"
	   title="Nation Table About The COVID19 Per State Reported"
	   >
	<tr align="center">
		<th> State </th>
		<th> Total Number Of Cases </th>
		<th> Total Number of Deaths </th>
		<th> Total Number of Tests </th>
    </tr>
	<?php
		require_once("connect.php");
		
		$sql = "SELECT * 
				FROM Nation";
		$result = mysqli_query($db, $sql);
    	while ($row = mysqli_fetch_assoc($result)) {

			echo "<tr align='center'>
				<td>" .$row['State']."</td>
				<td>".$row['TotalCases']."</td>
				<td>".$row['TotalDeaths']."</td>
				<td>".$row['TotalDeaths']."</td>
			</tr>";
		}
		mysqli_close($db); 
    ?>
</table>
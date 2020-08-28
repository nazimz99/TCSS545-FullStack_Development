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
		<th> Size Of Workforce </th>
		<th> Unemployment Percentage </th>
		<th> Lockdown Status </th>
    </tr>
	<?php
		require_once("connect.php");

		$sql = "SELECT * 
				FROM Workforce";
		$result = mysqli_query($db, $sql);

		while ($row = mysqli_fetch_assoc($result)) {
			echo '<tr align="center">
			<td>'.$row['State'].'</td>
			<td>'.$row['Workers'].'</td>
			<td>'.$row['Unemployment'].'</td>
			<td>'.$row['Lockdown'].'</td>
			</tr> ';

		}
		mysqli_close($db) 
	?>
</table>
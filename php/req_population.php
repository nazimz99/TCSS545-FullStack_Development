
<?php
    require_once("connect.php");
    
    $sql = "SELECT * 
            FROM Population";
    $result = mysqli_query($db, $sql);
    
	echo'<table border="10" 
		align="center" 
		cellspacing="10" 
		bordercolor="#0A7E71"
		aria-dropeffect="popup"
		cols="5"
		title="Nation Table About The COVID19 Per State Reported">
		<tr align="center">
		<th> State </th>
		<th> Population Size </th>
		<th> Population Density </th>
		<th> Cases Per 1 Million </th>
		<th> Deaths Per 1 Million</th>
		<th> Tests Per 1 Million</th>
		</tr>';

	while ($row = mysqli_fetch_assoc($result)) {
	echo '<tr align="center">
		<td>'.$row['State'].'</td>
		<td>'.$row['NumOfPeople'].'</td>
		<td>'.$row['Capita'].'</td>
		<td>'.$row['CaseDensity'].'</td>
		<td>'.$row['DeathDensity'].'</td>
		<td>'.$row['TestsDensity'].'</td>
		</tr> ';

	}
	echo'</table>';
		
   
    mysqli_close($db) 
?>

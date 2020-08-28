<table border="10" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="5"
	   title="States with Cases Below Average"
	   >
	<tr align="center">
		<th> State </th>
        <th> Cases vs. Tests Ratio </th>
        <th> Size of Workforce </th>
        <th> Unemployment Percentage </th>
        <th> Lockdown Status </th>
    </tr>
    <?php
        require_once("connect.php");
        $sql = "SELECT * FROM TestvsWorkforce";
        $result = mysqli_query($db, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr align='center'>
            <td>" .$row['State']."</td>
            <td>".$row['TestRatio']."</td>
            <td>".$row['Workers']."</td>
            <td>".$row['Unemployment']."</td>
            <td>".$row['Lockdown']."</td>
        </tr>";
        }  
    ?>
</table>
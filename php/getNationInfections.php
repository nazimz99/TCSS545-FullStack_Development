<table border="10" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="6"
	   title="National Statistics with Population and Current Infection Rate"
	   >
	<tr align="center">
		<th> State </th>
        <th> Population Size </th>
        <th> Current Infection Rate </th>
        <th> Total Cases </th>
        <th> Total Deaths </th>
        <th> Total Tests </th>
    </tr>
    <?php
        require_once("connect.php");
        $size = $_POST["size"];
        $sql = "CALL getNationInfectionsByPeople($size)";
        $result = mysqli_query($db, $sql);
        if (empty($size)) {
            echo "Please enter values in the fields.";
        }
        else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr align='center'>
                <td>" .$row['State']."</td>
                <td>".$row['NumOfPeople']."</td>
                <td>".$row['EndRate']."</td>
                <td>".$row['TotalCases']."</td>
                <td>".$row['TotalDeaths']."</td>
                <td>".$row['TotalTests']."</td>
            </tr>";
            }
		}
        mysqli_close($db);  
    ?>
</table>
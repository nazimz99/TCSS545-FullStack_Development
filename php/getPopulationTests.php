<table border="10" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="5"
	   title="Current Infection Rate vs. Current Population and Tests"
	   >
	<tr align="center">
		<th> State </th>
        <th> Current Infection Rate </th>
        <th> Total Tests</th>
        <th> Population Size </th>
        <th> Population Density </th>
    </tr>
    <?php
        require_once("connect.php");
        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $test = $_POST["test"];
        $size = $_POST["size"];
        $sql = "CALL getPopulationTests($test, $size)";
        $result = mysqli_query($db, $sql);
        if (empty($test) || empty($size)) {
            echo "Please enter values in the fields.";
            exit();
        }
        else {
            while ($row = mysqli_fetch_assoc($result)) {
                $State = $row['State'];
                $endrate = "SELECT getEndRate($State)";
                //$stmt = $mysqli->prepare($endrate);
                //$stmt->execute();
                //$output = $stmt->get_result();
//                $func = mysqli_query($db, $endrate);
//                $output = mysqli_result($func $row, 0);
                echo "<tr align='center'>
                <td>" .$row['State']."</td>
                <td>".$row['EndRate']."</td>
                <td>".$row['TotalTests']."</td>
                <td>".$row['NumOfPeople']."</td>
                <td>".$row['Capita']."</td>
            </tr>";
            }  
        }
        mysqli_close($db);
    ?>
</table>
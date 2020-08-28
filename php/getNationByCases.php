<table border="10" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="4"
	   title="National Statistics With Minimum Cases and Above Test Ratio Threshold"
	   >
	<tr align="center">
		<th> State </th>
        <th> Total Cases </th>
        <th> Total Deaths </th>
        <th> Total Tests </th>
    </tr>
    <?php
        require_once("connect.php");
        $cases = $_POST["cases"];
        $testratio = $_POST["ratio"];
        $sql = "CALL getNationByCases($cases, $testratio)";
        $result = mysqli_query($db, $sql);
        if(empty($cases) || empty($testratio)) {
            echo "Please enter values in the fields.";
            exit();
        }
        else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr align='center'>
                <td>" .$row['State']."</td>
                <td>".$row['TotalCases']."</td>
                <td>".$row['TotalDeaths']."</td>
                <td>".$row['TotalTests']."</td>
            </tr>";
            }  
        }
        mysqli_close($db);
    ?>
</table>
<table border="10" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="4"
	   title="Total Cases With Optimized Death and Test Ratio"
	   >
	<tr align="center">
		<th> State </th>
        <th> Total Cases </th>
        <th> Cases vs. Deaths Ratio</th>
        <th> Tests vs. Cases Ratio </th>
    </tr>
    <?php
        require_once("connect.php");
        $cases = $_POST["cases"];
        $deathratio = $_POST["death_ratio"];
        $testratio = $_POST["test_ratio"];
        $sql = "CALL getRatioCases($cases, $deathratio, $testratio)";
        $result = mysqli_query($db, $sql);
        if (empty($cases) || empty($deathratio) || empty($testratio)) {
            echo "Please enter values in the fields.";
            exit();
        }
        else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr align='center'>
                <td>" .$row['State']."</td>
                <td>".$row['TotalCases']."</td>
                <td>".$row['DeathRatio']."</td>
                <td>".$row['TestRatio']."</td>
            </tr>";
            }
        }  
        mysqli_close($db);
    ?>
</table>
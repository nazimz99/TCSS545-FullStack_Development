<table border="10" 
	   align="center" 
	   cellspacing="10" 
	   bordercolor="#0A7E71"
	   aria-dropeffect="popup"
	   cols="2"
	   title="State with Highest Cases"
	   >
	<tr align="center">
		<th> State </th>
		<th> Total Number Of Cases </th>
    </tr>
    <?php
        require_once("connect.php");
        $sql = "SELECT * FROM maxCases";
        $result = mysqli_query($db, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr align='center'>
            <td>" .$row['State']."</td>
            <td>".$row['TotalCases']."</td>
        </tr>";
        }  
    ?>
</table>
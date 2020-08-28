<?php
    require_once("connect.php");
    $State = $_POST["state"];
    $sql = "DELETE FROM Ratio
            WHERE State = '".$State."' AND STATE IN
            (SELECT State FROM Nation);";

	$query = "SELECT * FROM Ratio";
    $result = mysqli_query($db, $query);
    $target = NULL;
	if (empty($State)) 
        echo "Please enter a valid state.";
   
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['State'] == $State) {
            $target = $State;
            break;
        }
    }
	if (is_null($target)) {
        echo "The state entered does not exist.";
    }
	else{
		if (mysqli_query($db, $sql)) {
		  echo "Record deleted successfully";
		} else {
		  echo "Error deleting record: " . mysqli_error($db);
		}
	}
    mysqli_close($db);
?>
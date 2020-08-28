<?php
	require_once("connect.php");

    $State = $_POST["state"];
    $StartRate = $_POST["startrate"];
    $CurrentRate = $_POST["currentrate"];
    $sql = "INSERT INTO Infectionrate(State, StartRate, EndRate) VALUES
            ('$State', $StartRate, $CurrentRate)";
    $query = "SELECT * 
              FROM Infectionrate";
    $result = mysqli_query($db, $query);
    $target = NULL;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['State'] == $State) {
            $target = $State;
            break;
        }
    }
    if (empty($State) || empty($StartRate) || empty($CurrentRate))
        echo "Please enter a value in every field.";
    else if (!is_null($target)) {
        echo "The state already exists. Modify the state instead.";
    }
    else {
		if (mysqli_query($db, $sql)) {
		  echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($db);
		}

    }
    mysqli_close($db);
?>
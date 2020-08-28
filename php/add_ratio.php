<?php
    require_once("connect.php");
    $State = $_POST["state"];
    $TestRatio = $_POST["testratio"];
    $DeathRatio = $_POST["deathratio"];
    $sql = "INSERT INTO Ratio(State, TestRatio, DeathRatio) VALUES
            ('$State', $TestRatio, $DeathRatio)";
    $query = "SELECT * 
              FROM Ratio";
    $result = mysqli_query($db, $query);
    $target = NULL;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['State'] == $State) {
            $target = $State;
            break;
        }
    }
    if (empty($State) || empty($TestRatio) || empty($DeathRatio))
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
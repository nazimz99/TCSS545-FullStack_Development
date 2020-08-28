<?php
    require_once("connect.php");

    $State = $_POST["state"];
    $Workers = $_POST["workers"];
    $Unemployed = $_POST["unemployed"];
    $Lockdown = $_POST["lockdown"];
    $sql = "INSERT INTO Workforce(State, Workers, Unemployment, Lockdown) VALUES
            ('$State', $Workers, $Unemployed, $Lockdown)";
    $query = "SELECT * 
              FROM Workforce";
    $result = mysqli_query($db, $query);
    $target = NULL;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['State'] == $State) {
            $target = $State;
            break;
        }
    }
    if (empty($State) || empty($Workers) || empty($Unemployed) || empty($Lockdown))
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
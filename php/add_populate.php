<?php
    require_once("connect.php");

    $State = $_POST["state"];
    $NumOfPeople = $_POST["numofpeople"];
    $PopDensity = $_POST["pop_density"];
    $CaseDensity = $_POST["case_density"];
    $DeathDensity = $_POST["death_density"];
    $TestDensity = $_POST["test_density"];
    $sql = "INSERT INTO Population(State, NumOfPeople, Capita, CaseDensity, DeathDensity, TestsDensity) VALUES
            ('$State', $NumOfPeople, $PopDensity, $CaseDensity, $DeathDensity, $TestDensity)";
    $query = "SELECT * 
              FROM Population";
    $result = mysqli_query($db, $query);
    $target = NULL;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['State'] == $State) {
            $target = $State;
            break;
        }
    }
    if (empty($State) || empty($NumOfPeople) || empty($PopDensity) || empty($CaseDensity) || empty($DeathDensity) || empty($TestDensity))
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
?>
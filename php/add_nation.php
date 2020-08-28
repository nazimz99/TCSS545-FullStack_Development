<?php
    require_once("connect.php");
    
    $State = $_POST["state"];
    $TotalCases = $_POST["totalcases"];
    $TotalDeaths = $_POST["totaldeaths"];
    $TotalTests = $_POST["totaltests"];
    $sql = "INSERT INTO Nation(State, TotalCases, TotalDeaths, TotalTests) VALUES
            ('$State', $TotalCases, $TotalDeaths, $TotalTests)";
    $query = "SELECT * 
              FROM Nation";
    $result = mysqli_query($db, $query);
    $target = NULL;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['State'] == $State) {
            $target = $State;
            break;
        }
    }
    if (empty($State) || empty($TotalCases) || empty($TotalDeaths) || empty($TotalTests))
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
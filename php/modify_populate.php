<?php
    require_once("connect.php");

    $State = $_POST["state"];
    $NumOfPeople = $_POST["numofpeople"];
    $PopDensity = $_POST["pop_density"];
    $CaseDensity = $_POST["case_density"];
    $DeathDensity = $_POST["death_density"];
    $TestDensity = $_POST["test_density"];
    $query = "SELECT * 
              FROM Population";
    $result = mysqli_query($db, $query);
    if (empty($State)) {
        echo "Please enter a valid value for the state.";
        exit();
    }
    else {
        $target = NULL;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['State'] == $State) {
                $target = $State;
                if (empty($NumOfPeople)) $NumOfPeople = $row['NumOfPeople'];
                if (empty($PopDensity)) $PopDensity = $row['Capita'];
                if (empty($CaseDensity)) $CaseDensity = $row['CaseDensity'];
                if (empty($DeathDensity)) $DeathDensity = $row['DeathDensity'];
                if (empty($TestDensity)) $TestDensity = $row['TestsDensity'];
                break;
            }
        }
        $sql = "UPDATE Population
                SET NumOfPeople = '".$NumOfPeople."', Capita = '".$PopDensity."', CaseDensity = '".$CaseDensity."', DeathDensity = '".$DeathDensity."'
                WHERE State = '".$State."'";
        if (is_null($target)) echo "Enter a valid state to modify";
        else if (mysqli_query($db, $sql) != FALSE) {
            //mysqli_query($db, $sql);
            echo "Query successfully completed";
        }
    }
    mysqli_close($db);
?>
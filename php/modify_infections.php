<?php
    require_once("connect.php");

    $State = $_POST["state"];
    $StartRate = $_POST["startrate"];
    $CurrentRate = $_POST["currentrate"];
    $query = "SELECT * 
              FROM Infectionrate;";
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
                if (empty($StartRate)) $StartRate = $row['StartRate'];
                if (empty($CurrentRate)) $PopDensity = $row['EndRate'];
                break;
            }
        }
        $sql = "UPDATE Infectionrate
                SET StartRate = '".$StartRate."', EndRate = '".$CurrentRate."'
                WHERE State = '".$State."';";
        if (is_null($target) != FALSE) echo "Enter a valid state to modify.";
        else if (mysqli_query($db, $sql)) {
            //mysqli_query($db, $sql);
            echo "Query successfully completed";
        }
    }
    mysqli_close($db);
?>
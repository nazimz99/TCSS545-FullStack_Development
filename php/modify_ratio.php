<?php
    require_once("connect.php");

    $State = $_POST["state"];
    $TestRatio = $_POST["testratio"];
    $DeathRatio = $_POST["deathratio"];
    $query = "SELECT * 
              FROM Ratio";
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
                if (empty($TestRatio)) $TestRatio = $row['TestRatio'];
                if (empty($DeathRatio)) $DeathRatio = $row['DeathRatio'];
                break;
            }
        }
        $sql = "UPDATE Ratio
                SET TestRatio = '".$TestRatio."', DeathRatio = '".$DeathRatio."'
                WHERE State = $State";

        if (is_null($target)) echo "Enter a valid state to modify";
        else if (mysqli_query($db, $sql) != FALSE) {
            //mysqli_query($db, $sql);
            echo "Query successfully completed";
        }
    }
    mysqli_close($db);
?>
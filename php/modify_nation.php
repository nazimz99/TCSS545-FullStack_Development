<?php
    require_once("connect.php");

    $State = $_POST["state"];
    $TotalCases = $_POST["totalcases"];
    $TotalDeaths = $_POST["totaldeaths"];
    $TotalTests = $_POST["totaltests"];
    $query = "SELECT * 
              FROM Nation";
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
                if (empty($TotalCases)) $TotalCases = $row['TotalCases'];
                if (empty($TotalDeaths)) $TotalDeaths = $row['TotalDeaths'];
                if (empty($TotalTests)) $TotalTests = $row['TotalTests'];
                break;
            }
        }
        $sql = "UPDATE Nation
                SET TotalCases = '".$TotalCases."', TotalDeaths = '".$TotalDeaths."', TotalTests = '".$TotalTests."'
                WHERE State = '".$State."'";
        if (is_null($target)) echo "Enter a valid state to modify.";
        else if (mysqli_query($db, $sql) != FALSE) {
            //mysqli_query($db, $sql);
            echo "Query successfully completed";
        }
    }
    mysqli_close($db);
?>
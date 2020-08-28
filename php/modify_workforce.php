<?php
    require_once("connect.php");

    $State = $_POST["state"];
    $Workers = $_POST["workers"];
    $Unemployment = $_POST["unemployed"];
    $Lockdown = $_POST["lockdown"];
    $query = "SELECT * 
              FROM Workforce";
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
                if (empty($Workers)) $Workers = $row['Workers'];
                if (empty($Unemployment)) $Unemployment = $row['Unemployment'];
                if (empty($Lockdown)) $Lockdown = $row['Lockdown'];
                break;
            }
        }
        $sql = "UPDATE Workforce
                SET Workers = '".$Workers."', Unemployment = '".$Unemployment."', Lockdown = '".$Lockdown."'
                WHERE State = '".$State."'";
        if (is_null($target)) echo "Enter a valid state to modify.";
        else if (mysqli_query($db, $sql) != FALSE) {
            //mysqli_query($db, $sql);
            echo "Query successfully completed";
        }
    }
    mysqli_close($db);
?>
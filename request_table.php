<table>
    <?php
        $sql=$db->prepare('SELECT * FROM :table')
        $sql->execute(array(':table'=>$_REQUEST[Table]));

        while ($row=$sql->fetch()) {
            if (':table' = 'Population') {
                echo "<tr><td></td><td>$row[NumOfPeople]</td><td>$row[Capita]</td><td>$row[CaseDensity]<td>$row[DeathDensity]</td><td>$row[TestsDensity]</td></tr>";
            }
            if (':table' = 'Infectionrate') {
                echo "<tr><td></td><td>$row[StartRate]</td><td>$row[EndRate]</td></tr>"
            }
    ?>
</table>
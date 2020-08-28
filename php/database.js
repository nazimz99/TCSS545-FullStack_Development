module.export = {
    search({state}) {
        console.log('Search state ${state}');
        return Promise.resolve();
    }
}

SELECT State, TotalCases, Deaths, Tests
FROM Nation 
NATURAL JOIN Ratio
WHERE testRatio IN (SELECT testRatio
                    FROM Ratio 
                    WHERE Ratio >= INPUT)
AND TotalCases="INPUT";

SELECT State, NumOfPeople, DifferenceRate, TotalCases, TotalDeaths, TotalTests
FROM Nation 
INNER JOIN Population ON Nation.State=Population.State
INNER JOIN Progress ON Nation.State=Progress.State
WHERE TotalDeaths="INPUT";

SELECT State, TestRatio, Unemployment, Lockdown, StartRate, EndRate
FROM Nation AS N1
INNER JOIN Workforce AS W ON N1.State=W.State 
INNER JOIN Infectionrate AS R1 ON N1.State=R.State
INNER JOIN TestRatio AS T ON N1.State = T.State
WHERE EndRate >= (SELECT StartRate
                  FROM InfectionRate as R2
                  WHERE N1.State = R2.State);
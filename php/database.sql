/*
-----------------------------Completed--------------------------------------
SELECT * 
FROM Nation
ORDER BY TotalCases, TotalTests, TotalDeaths DESC;

SELECT * 
FROM Population
ORDER BY Population, CaseDensity, TestsDensity DESC;

SELECT * 
FROM Ratio 
ORDER BY TestRatio DESC, DeathRatio ASC;

SELECT *
FROM Infectionrate
ORDER BY (EndRate-StartRate) DESC;

SELECT * 
FROM Workforce
ORDER BY Unemployment, Workers DESC; */

CREATE PROCEDURE getNationByCases(IN cases INT, IN ratio DECIMAL(2, 2))
BEGIN
    SELECT *
    FROM Nation 
    INNER JOIN Ratio ON Nation.State = Ratio.State
    WHERE testRatio IN (SELECT testRatio
                        FROM Ratio 
                        WHERE testRatio >= ratio)
    AND TotalCases<=cases;
END;

CALL getNationByCases("INPUT", "INPUT");

CREATE PROCEDURE getNationInfectionsByPeople(IN size INT)
BEGIN
    SELECT State, NumOfPeople, (EndRate-StartRate), TotalCases, TotalDeaths, TotalTests
    FROM Nation 
    INNER JOIN Population ON Nation.State=Population.State
    INNER JOIN Infections ON Nation.State=Infections.State
    WHERE NumOfPeople=size;
END; 

CALL getNationInfectionsByPeople("INPUT");

SELECT State, TestRatio, Unemployment, Lockdown
FROM Nation AS N1
INNER JOIN Workforce AS W ON N1.State=W.State 
INNER JOIN Infectionrate AS R1 ON N1.State=R1.State
INNER JOIN TestRatio AS T ON N1.State = T.State
WHERE EndRate >= (SELECT StartRate
                  FROM Infectionrate as R2
                  WHERE N1.State = R2.State);

GO
CREATE VIEW NationStatus AS
    SELECT State, TotalCases, DeathRatio, TestRatio
    FROM Nation, Ratio
    WHERE Nation.State=Ratio.State AND TotalCases <= "INPUT" AND DeathRatio <= "INPUT" AND TestRatio <= "INPUT";

GO
SELECT * FROM NationStatus;
  
GO
CREATE VIEW PopulationStatus AS 
    SELECT STATE, TotalDeaths, TotalTests, Population, Capita
    FROM Nation, Population
    WHERE Nation.State = Population.State AND TotalTests >= "INPUT" AND Population>= "INPUT"
    AND Nation.State IN (SELECT STATE
                         FROM Infections
                         WHERE EndRate >= StartRate);

GO
SELECT * FROM PopulationStatus;

GO
CREATE VIEW greaterAvgCases AS
    SELECT State, TotalCases, TotalTests, TotalDeaths
    FROM Nation
    HAVING TotalCases >= AVG(TotalCases);

GO
SELECT * FROM greaterAvgCases;

GO 
CREATE VIEW lowerAvgCases AS
    SELECT State, TotalCases, TotalTests, TotalDeaths
    FROM Nation
    HAVING TotalCases <= AVG(TotalCases);

GO
SELECT * FROM lowerAvgCases;

GO
CREATE VIEW maxCases AS 
    SELECT State, TotalCases, TotalDeaths, NumOfPeople, Unemployment, (EndRate-StartRate)
    FROM Nation AS N, Population AS P, Workforce AS W, Infectionrate AS R
    WHERE N.State=P.State AND N.State=W.State AND N.State=R.State AND 
    TotalCases >= ALL (SELECT TotalCases FROM Nation);

GO
SELECT * FROM maxCases;

GO
CREATE VIEW minCases AS 
    SELECT State, TotalCases, TotalDeaths, NumOfPeople, Unemployment, (EndRate-StartRate)
    FROM Nation AS N, Population AS P, Workforce AS W, Infectionrate AS R
    WHERE N.State=P.State AND N.State=W.State AND N.State=R.State AND 
    TotalCases <= ALL (SELECT TotalCases FROM Nation);

GO
SELECT * FROM minCases;

/*-------------------------ALL TRIGGERS-----------------------------*/
GO
CREATE TRIGGER InsertRatio 
BEFORE INSERT ON Ratio
REFERENCING NEW ROW AS NEW 
FOR EACH ROW 
WHEN
    IF NOT EXISTS
        (SELECT State FROM Ratio WHERE State IN
            (SELECT State FROM Nation))
    INSERT INTO Nation(State, TotalCases, TotalDeaths, TotalTests) VALUES
    (New.State, 1, 1, 1);

CREATE TRIGGER InsertPopulation 
BEFORE INSERT ON Population
REFERENCING NEW ROW AS NEW 
FOR EACH ROW 
WHEN
    IF NOT EXISTS
        (SELECT State FROM Population WHERE State IN
            (SELECT State FROM Nation))
    INSERT INTO Nation(State, TotalCases, TotalDeaths, TotalTests) VALUES
    (New.State, 1, 1, 1);

CREATE TRIGGER InsertInfections
BEFORE INSERT ON Infectionrate
REFERENCING NEW ROW AS NEW 
FOR EACH ROW 
WHEN
    IF NOT EXISTS
        (SELECT State FROM Infectionrate WHERE State IN
            (SELECT State FROM Nation))
    INSERT INTO Nation(State, TotalCases, TotalDeaths, TotalTests) VALUES
    (New.State, 1, 1, 1);

CREATE TRIGGER InsertWorkforce
BEFORE INSERT ON Workforce
REFERENCING NEW ROW AS NEW 
FOR EACH ROW 
WHEN
    IF NOT EXISTS
        (SELECT State FROM Workforce WHERE State IN
            (SELECT State FROM Nation))
    INSERT INTO Nation(State, TotalCases, TotalDeaths, TotalTests) VALUES
    (New.State, 1, 1, 1);

CREATE TRIGGER InsertNation 
AFTER INSERT ON Nation
REFERENCING NEW ROW As New
FOR EACH ROW 
WHEN
    (SELECT State FROM Ratio WHERE New.State=Ratio.State)
INSERT INTO Ratio(State, TestRatio, DeathRatio) VALUES
    (Ratio.State, New.TotalCases/New.TotalTests, New.TotalDeaths/New.TotalCases);

CREATE TRIGGER UpdateNation
AFTER UPDATE ON Nation
REFERENCING NEW ROW As New
FOR EACH ROW 
WHEN
    (SELECT State FROM Ratio WHERE New.State=Ratio.State)
UPDATE Ratio 
SET TestRatio = New.TotalCases/TotalTests, DeathRatio = New.TotalDeaths/New.TotalCases;



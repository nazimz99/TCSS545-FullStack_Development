SHOW GRANTS;
GRANT ALL ON mydatabase.* TO 'kkinoc'@'%';
SET GLOBAL log_bin_trust_function_creators = 1;

CREATE TABLE Nation (
State   varchar(32) NOT NULL PRIMARY KEY,
TotalCases  INT DEFAULT 0,
TotalDeaths INT DEFAULT 0,
TotalTests  INT DEFAULT 0);

CREATE TABLE Ratio (
State varchar(32) NOT NULL PRIMARY KEY,
TestRatio   DECIMAL(2,2) NOT NULL,
DeathRatio DECIMAL(2,2) NOT NULL,
FOREIGN KEY(State) REFERENCES Nation(State)
ON DELETE CASCADE
);

CREATE TABLE Population (
 State varchar(32) NOT NULL PRIMARY KEY,
 NumOfPeople INT NOT NULL,
 Capita INT DEFAULT 0,
 CaseDensity INT DEFAULT 0,
 DeathDensity INT DEFAULT 0,
 TestsDensity INT DEFAULT 0,
 FOREIGN KEY(State) REFERENCES Nation(State)
 ON DELETE CASCADE
);

CREATE TABLE Infectionrate (
 State varchar(32) NOT NULL PRIMARY KEY,
 StartRate INT  NOT NULL,
 EndRate   INT  NOT NULL,
 FOREIGN KEY(State) REFERENCES Nation(State)
 ON DELETE CASCADE
);

CREATE TABLE Workforce (
 State varchar(32) NOT NULL PRIMARY KEY,
 Workers INT    NOT NULL,
 Unemployment DECIMAL(1, 3) NOT NULL,
 Lockdown   varchar(16) NOT NULL,
 FOREIGN KEY(State) REFERENCES Nation(State)
 ON DELETE CASCADE
);

INSERT INTO Nation(State, totalCases, totalDeaths, totalTests) VALUES
('New York', 362577, 28636, 1480828),
('New Jersey', 150087, 10448, 525537),
('California', 81715, 3322, 1371488),
('Texas', 50055, 1390, 754135),
('Florida', 46944, 2052, 717162),
('Georgia', 38721, 1664, 378156),
('Louisiana', 35038, 2581, 278073),
('Washington', 19510, 1019, 289717),
('North Carolina', 19844, 719, 265008),
('Massachusetts', 87925, 5938, 476940);

INSERT INTO Ratio(State, TestRatio, DeathRatio) VALUES
('New York', 0.24, 0.13),
('New Jersey', 0.29, 0.14),
('California', 0.06, 0.25),
('Texas', 0.07, 0.36),
('Florida', 0.07, 0.23),
('Georgia', 0.10, 0.23),
('Louisiana', 0.13, 0.14),
('Washington', 0.05, 0.19),
('North Carolina', 0.07, 0.28),
('Massachusetts', 0.18, 0.15);

INSERT INTO Population(State, NumOfPeople, Capita, CaseDensity, DeathDensity, TestsDensity) VALUES
('New York', 19440469, 413, 18638, 1472, 76121),
('New Jersey', 8936574, 1215, 16898, 1176, 59268),
('California', 39937489, 256, 2068, 84, 34710),
('Texas', 29472295, 113, 1726, 48, 26008),
('Florida', 21992985, 410, 2186, 96, 33391),
('Georgia', 10736059, 187, 3647, 157, 35617),
('Louisiana', 4645184, 108, 7537, 555, 59816),
('Washington', 7797095, 117, 2562, 134, 38046),
('North Carolina', 10611862, 218, 1892, 69, 25268),
('Massachusetts', 6976597, 894, 12757, 862, 69197);

INSERT INTO Infectionrate(State, StartRate, EndRate) VALUES
('New York', 5048, 1763),
('New Jersey', 3166, 1736),
('California', 1076, 1968),
('Texas', 626, 1190),
('Florida', 1027, 760),
('Georgia', 630, 564),
('Louisiana', 1409, 441),
('Washington', 345, 188),
('North Carolina', 234, 641),
('Massachusetts', 1066, 1067);


INSERT INTO Status(State, Workforce, Unemployment, Lockdown) VALUES
('New York', 9723000, 0.189, ''),
('New Jersey', 4161200, 0.239, ''),
('California', 3773638, 0.233, ''),
('Texas', 12968900, 0.141, ''),
('Florida', 9106500, 0.195, ''),
('Georgia', 4622000, 0.348, ''),
('Lousiana', 1985800, 0.284, ''),
('Washington', 3482700, 0.28, ''),
('North Carolina', 4569000, 0.184, ''),
('Massachusetts', 3649200, 0.218, '');

DROP TRIGGER InsertNation;
DROP TRIGGER UpdateNation;

DELIMITER $$
CREATE TRIGGER UpdateNation
AFTER UPDATE ON Nation
FOR EACH ROW 
IF EXISTS
    (SELECT NEW.State IN (SELECT State FROM Ratio))
THEN UPDATE Ratio 
SET TestRatio = NEW.TotalCases/NEW.TotalTests, DeathRatio = NEW.TotalDeaths/NEW.TotalCases
WHERE State=NEW.State;
END IF; $$

CREATE TRIGGER InsertNation 
AFTER INSERT ON Nation
FOR EACH ROW 
IF EXISTS
    (SELECT NEW.State NOT IN (SELECT State FROM Ratio))
THEN INSERT INTO Ratio(State, TestRatio, DeathRatio) VALUES
    (NEW.State, NEW.TotalCases/NEW.TotalTests, NEW.TotalDeaths/NEW.TotalCases);
END IF; $$

INSERT INTO Ratio(State, DeathRatio, TestRatio) VALUES ('Nevada', 0.1, 0.1)$$
UPDATE Nation SET TotalCases=100, TotalTests=200, TotalDeaths=80 WHERE State='Nevada' $$
INSERT INTO Nation(State, TotalCases, TotalDeaths, TotalTests) VALUES ('lmao', 200, 40, 800) $$
UPDATE Nation SET TotalCases=400 WHERE State='lmao' $$
SELECT * FROM Nation $$
SELECT * FROM Ratio $$
DELETE FROM Nation WHERE State='lmao' $$

CREATE PROCEDURE getNationByCases(IN cases INT, IN ratio DECIMAL(2, 2))
BEGIN
    SELECT *
    FROM Nation 
    INNER JOIN Ratio ON Nation.State = Ratio.State
    WHERE totalCases <= cases AND testRatio IN (SELECT testRatio
                        FROM Ratio 
                        WHERE testRatio >= ratio);
END; $$

CREATE PROCEDURE getNationInfectionsByPeople(IN size INT)
BEGIN
    SELECT Nation.State, NumOfPeople, EndRate, TotalCases, TotalDeaths, TotalTests
    FROM Nation 
    INNER JOIN Population ON Nation.State=Population.State
    INNER JOIN Infectionrate ON Nation.State=Infectionrate.State
    WHERE NumOfPeople>=size;
END; $$

CREATE PROCEDURE getRatioCases(IN cases INT, IN deaths DECIMAL(2, 2), IN tests DECIMAL(2, 2)) 
BEGIN
    SELECT Nation.State, TotalCases, DeathRatio, TestRatio
    FROM Nation, Ratio
    WHERE Nation.State=Ratio.State AND TotalCases <= cases AND DeathRatio <= deaths AND TestRatio >= tests;
END; $$

CREATE FUNCTION getEndRate(state varchar(32)) 
	RETURNS INTEGER
    RETURN 
		(SELECT EndRate
         FROM Nation, Infectionrate
         WHERE Nation.State=Infectionrate.State AND Nation.State=state); $$
         
DROP FUNCTION getEndRate $$
         
CREATE PROCEDURE getPopulationTests(tests INT, size INT) 
    BEGIN 
        SELECT N.State, EndRate, TotalTests, NumOfPeople, Capita
        FROM Nation AS N, Population AS P, Infectionrate AS R
        WHERE N.State = P.State AND N.State=R.State AND TotalTests >= tests AND NumOfPeople >= size
        AND N.State IN (SELECT STATE
                            FROM Infectionrate
                            WHERE EndRate >= StartRate);
	END; $$

DROP PROCEDURE getPopulationTests $$ 

CREATE VIEW TestvsWorkforce AS
    SELECT N.State, TestRatio, Workers, Unemployment, Lockdown
    FROM Nation AS N, Workforce AS W, Infectionrate AS R1, Ratio as T
    WHERE N.State=W.State AND N.State=R1.State AND N.State=T.State
    AND EndRate <= (SELECT StartRate
                    FROM Infectionrate AS R2
                    WHERE N.State = R2.State) $$
    
DROP VIEW TestvsWorkforce $$
DROP VIEW greaterAvgCases $$
DROP VIEW lowerAvgCases $$
SELECT * FROM TestvsWorkforce $$
CALL getNationInfectionsByPeople(50000) $$
CALL getNationByCases(120000, 0.20) $$
CALL getRatioCases(120000, 0.15, 0.25) $$
CALL getPopulationTests(300000, 4000000) $$

CREATE VIEW greaterAvgCases AS
    SELECT State, TotalCases
    FROM Nation
    WHERE TotalCases >= (SELECT AVG(TotalCases) FROM Nation) $$

CREATE VIEW lowerAvgCases AS
    SELECT State, TotalCases
    FROM Nation
    WHERE TotalCases <= (SELECT AVG(TotalCases) FROM Nation) $$

CREATE VIEW maxCases AS 
    SELECT State, TotalCases
    FROM Nation
    WHERE TotalCases >= ALL (SELECT TotalCases FROM Nation) $$

CREATE VIEW minCases AS 
    SELECT State, TotalCases
    FROM Nation 
    WHERE TotalCases <= ALL (SELECT TotalCases FROM Nation) $$

DELIMITER ;

ALTER TABLE Nation ADD INDEX nationIndex(State);
ALTER TABLE Ratio ADD INDEX ratioIndex(State);
ALTER TABLE Population ADD INDEX populationIndex(State);
ALTER TABLE Infectionrate ADD INDEX rateIndex(State);
ALTER TABLE Workforce ADD INDEX workIndex(State);

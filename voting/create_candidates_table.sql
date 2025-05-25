-- Create database (if not exists)
CREATE DATABASE IF NOT EXISTS voting_db;
USE voting_db;

-- Candidates table
CREATE TABLE IF NOT EXISTS candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    votes INT DEFAULT 0
);

-- Insert sample candidates for ICPEP organization

-- President (single vote)
INSERT INTO candidates (name, position) VALUES
('Alice Johnson', 'President'),
('Bob Smith', 'President');

-- Vice-President (single vote)
INSERT INTO candidates (name, position) VALUES
('Charlie Brown', 'Vice-President'),
('David Lee', 'Vice-President');

-- External (single vote)
INSERT INTO candidates (name, position) VALUES
('Emma Davis', 'External'),
('Frank Miller', 'External');

-- Internal (single vote)
INSERT INTO candidates (name, position) VALUES
('Grace Kim', 'Internal'),
('Henry Wilson', 'Internal');

-- Secretary (single vote)
INSERT INTO candidates (name, position) VALUES
('Ivy Martinez', 'Secretary'),
('Jack Turner', 'Secretary');

-- Assistant Secretary (single vote)
INSERT INTO candidates (name, position) VALUES
('Karen Scott', 'Assistant Secretary'),
('Liam Roberts', 'Assistant Secretary');

-- Treasurer (single vote)
INSERT INTO candidates (name, position) VALUES
('Mia Clark', 'Treasurer'),
('Noah Lewis', 'Treasurer');

-- Assistant Treasurer (single vote)
INSERT INTO candidates (name, position) VALUES
('Olivia Young', 'Assistant Treasurer'),
('Paul Walker', 'Assistant Treasurer');

-- Auditor (single vote)
INSERT INTO candidates (name, position) VALUES
('Quinn Hill', 'Auditor'),
('Rachel Adams', 'Auditor');

-- Business Manager (2 votes allowed)
INSERT INTO candidates (name, position) VALUES
('Samuel Green', 'Business Manager'),
('Tina Nelson', 'Business Manager'),
('Uma Patel', 'Business Manager');

-- P. R. O (2 votes allowed)
INSERT INTO candidates (name, position) VALUES
('Victor Martinez', 'P. R. O'),
('Wendy Johnson', 'P. R. O'),
('Xander Harris', 'P. R. O');

-- Property Custodian (2 votes allowed)
INSERT INTO candidates (name, position) VALUES
('Yara Fisher', 'Property Custodian'),
('Zachary Lee', 'Property Custodian'),
('Angela Collins', 'Property Custodian');

-- Quizzer Head (2 votes allowed)
INSERT INTO candidates (name, position) VALUES
('Brian Evans', 'Quizzer Head'),
('Claire Stewart', 'Quizzer Head'),
('Derek Morris', 'Quizzer Head');

-- Sports Head (2 votes allowed)
INSERT INTO candidates (name, position) VALUES
('Eleanor Turner', 'Sports Head'),
('Felix Cook', 'Sports Head'),
('Gina Ross', 'Sports Head');

-- Multimedia Head (2 votes allowed)
INSERT INTO candidates (name, position) VALUES
('Hannah Baker', 'Multimedia Head'),
('Ian Collins', 'Multimedia Head'),
('Jenny Clark', 'Multimedia Head');
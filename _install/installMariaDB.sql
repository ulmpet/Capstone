CREATE DATABASE IF NOT EXISTS phage_enzyme_tool;

USE phage_enzyme_tool;

CREATE TABLE IF NOT EXISTS genusTable(
	GenusID INT NOT NULL AUTO_INCREMENT primary key,
	Genus VARCHAR(100)
	);

CREATE TABLE IF NOT EXISTS userTable
(
	UserID INTEGER NOT NULL AUTO_INCREMENT primary key,
	EmailAddress VARCHAR(100),
	Password VARCHAR(128),
	Root BOOLEAN,
	VerificationValue VARCHAR(128),
	IPAdress VARCHAR(15),
	Organization VARCHAR(50)
);

CREATE TABLE cutsTable
(
	CutID INTEGER NOT NULL AUTO_INCREMENT primary key,
	PhageID INTEGER,
	EnzymeID INTEGER,
	CutCount INTEGER,
	CutLocations text
);

CREATE TABLE enzymeTable
(
	EnzymeID INTEGER AUTO_INCREMENT NOT NULL primary key,
	EnzymeName VARCHAR(100),
	CutPattern VARCHAR(50) # do we keep this? 
);

CREATE TABLE clusterTable
(
	ClusterID INTEGER AUTO_INCREMENT NOT NULL primary key,
	Cluster VARCHAR(3)
	
);

CREATE TABLE phageTable
(
	
	PhageID INTEGER AUTO_INCREMENT NOT NULL primary key,
	PhageName VARCHAR(100),
	GenusID INTEGER,
	ClusterID INTEGER,
	SubclusterID INTEGER,
	YearFound INTEGER,
	DateFinished DATE,
	Gnome MEDIUMTEXT
);
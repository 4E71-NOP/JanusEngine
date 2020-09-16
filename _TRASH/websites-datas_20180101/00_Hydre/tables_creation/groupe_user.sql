/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des utilisateurs associes a un groupe																			*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/* user_id 																															*/
/* groupe_id 																														*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
groupe_premier	NON 0	OUI 1
*/
CREATE TABLE !table! ( 
groupe_user_id	INTEGER NOT NULL,
groupe_id		INTEGER,
user_id			INTEGER,
groupe_premier	INTEGER,
PRIMARY KEY (groupe_user_id)
);

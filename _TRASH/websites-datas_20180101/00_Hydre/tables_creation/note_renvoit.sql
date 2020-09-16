/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des notes de renvoit																							*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
noterenvoit_origine 	CORRECTION 0	VALIDATION 1
*/

CREATE TABLE !table! (
noterenvoit_id INTEGER NOT NULL,
noterenvoit_docu_id 	INTEGER,
noterenvoit_user_id 	INTEGER,
noterenvoit_date 		INTEGER,
noterenvoit_origine 	INTEGER,
noterenvoit_contenu 	BLOB,
PRIMARY KEY (noterenvoit_id)
);


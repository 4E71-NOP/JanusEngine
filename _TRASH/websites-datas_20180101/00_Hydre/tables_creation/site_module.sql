/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des module associes a un site web																				*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/* site_id 																															*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
module_etat		OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
site_module_id	INTEGER NOT NULL,
site_id 		INTEGER,
module_id		INTEGER,
module_etat 	INTEGER,
module_position	INTEGER,
PRIMARY KEY (site_module_id)
);

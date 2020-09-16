/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des groupes associes a un site web																				*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/* site_id 																															*/
/* groupe_id 																														*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
groupe_etat 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
site_groupe_id	INTEGER NOT NULL,
site_id			INTEGER,
groupe_id		INTEGER,
groupe_etat 	INTEGER,
PRIMARY KEY (site_groupe_id)
);

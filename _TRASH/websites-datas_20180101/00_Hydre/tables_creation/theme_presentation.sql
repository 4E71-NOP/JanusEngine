/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table d association des themes et des presentations																	*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/*	theme_id																														*/
/*	pres_id																															*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
pres_defaut		NON 0	OUI 1
*/

CREATE TABLE !table! (
theme_pres_id 	INTEGER NOT NULL,
theme_id 		INTEGER,
pres_id 		INTEGER,
pres_defaut		INTEGER,
PRIMARY KEY (theme_pres_id)
);

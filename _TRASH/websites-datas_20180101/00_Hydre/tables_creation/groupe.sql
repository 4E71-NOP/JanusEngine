/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des groupes de tout les sites web																				*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
groupe_tag		ANONYME 0	LECTEUR 1	STAFF 2	SENIOR_STAFF 3
*/
CREATE TABLE !table! ( 
groupe_id		INTEGER NOT NULL,
groupe_parent	INTEGER,
groupe_tag		INTEGER,
groupe_nom		VARCHAR (255),
groupe_titre	VARCHAR (255),
groupe_fichier	VARCHAR (255),
groupe_desc		VARCHAR (255),
PRIMARY KEY (groupe_id)
);

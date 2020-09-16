/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des documents																									*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
docu_type					WMCODE 0	NOCODE 1	PHP 2	MIXED 3
origine = site_id mais n est pas une clé étrangère 
juste un renseignement sur le site a qui appartien tout les droits de ce document.
*/

CREATE TABLE !table! (
docu_id 					INTEGER NOT NULL,
docu_nom					VARCHAR(255),
docu_type					INTEGER,
docu_origine				INTEGER,

docu_createur				INTEGER,
docu_creation_date			INTEGER,

docu_correction				INTEGER,
docu_correcteur				INTEGER,
docu_correction_date		INTEGER,
docu_cont 					BLOB,
PRIMARY KEY (docu_id)
);

/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
docu_type					WMCODE 0	NOCODE 1	PHP 2	MIXED 3
origine = ws_id mais n est pas une clé étrangère 
juste un renseignement sur le site a qui appartien tout les droits de ce document.
*/

CREATE TABLE !table! (
docu_id 					INTEGER NOT NULL,
docu_name					VARCHAR(255),
docu_type					INTEGER,
docu_origin				INTEGER,

docu_creator				INTEGER,
docu_creation_date			INTEGER,

docu_examination				INTEGER,
docu_examiner				INTEGER,
docu_examination_date		INTEGER,
docu_cont 					BLOB,

PRIMARY KEY (docu_id)

);

/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
docu_type					WMCODE 0	NOCODE 1	PHP 2	MIXED 3
docu_type					0:HTML	1:PHP(exec)	2:MIXED(PHP/HTML)

origine = ws_id mais n est pas une clé étrangère 
juste un renseignement sur le site a qui appartien tout les droits de ce document.
*/

CREATE TABLE !table! (
docu_id 					BIGINT NOT NULL UNIQUE, 
docu_name					VARCHAR(255),
docu_type					INTEGER,
docu_origin		    		BIGINT,

docu_creator				BIGINT,
docu_creation_date			INTEGER,

docu_validation		    	INTEGER,
docu_validator				BIGINT,
docu_validation_date		INTEGER,
docu_cont 					BLOB,

PRIMARY KEY (docu_id)

);

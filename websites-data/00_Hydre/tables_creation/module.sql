/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
module_deco 		DECO_OFF 0	DECO_ON 1
module_adm_control	NO 0	YES 1
module_deco_txt_defaut 1 à 7
*/

CREATE TABLE !table! (
module_id 					INTEGER NOT NULL,
module_deco 				INTEGER,
module_deco_nbr 			INTEGER,
module_deco_txt_defaut		INTEGER,
module_nom 					VARCHAR(255),
module_classname			VARCHAR(255),
module_titre 				VARCHAR(255),
module_directory 			VARCHAR(255),
module_fichier 				VARCHAR(255),
module_desc 				VARCHAR(255),
module_conteneur_nom		VARCHAR(255),
module_groupe_pour_voir 	INTEGER,
module_groupe_pour_utiliser INTEGER,
module_adm_control			INTEGER,
module_execution			INTEGER,

PRIMARY KEY (module_id)

);

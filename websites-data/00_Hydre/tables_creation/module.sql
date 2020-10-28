/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
module_deco 		DECO_OFF 0	DECO_ON 1
module_adm_control	NO 0	YES 1
module_deco_default_text 1 à 7
*/

CREATE TABLE !table! (
module_id 						INTEGER NOT NULL,
module_deco 					INTEGER,
module_deco_nbr 				INTEGER,
module_deco_default_text		INTEGER,
module_name 					VARCHAR(255),
module_classname				VARCHAR(255),
module_title 					VARCHAR(255),
module_directory 				VARCHAR(255),
module_file 					VARCHAR(255),
module_desc 					VARCHAR(255),
module_container_name			VARCHAR(255),
module_container_style			VARCHAR(255),
module_group_allowed_to_see 	INTEGER,
module_group_allowed_to_use 	INTEGER,
module_adm_control				INTEGER,
module_execution				INTEGER,

PRIMARY KEY (module_id)

);

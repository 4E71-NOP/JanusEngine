/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
arti_type					WMCODE 0	NOCODE 1	PHP 2	MIXED 3
arti_show_info				SHOW_INFO_OFF 0	SHOW_INFO_ON 1
arti_validation_state		NON_VALIDE 0	VALIDE 1
arti_correction_etat		NON_CORRIGE 0 CORRIGE 1
*/

CREATE TABLE !table! (
arti_id 					INTEGER NOT NULL,
arti_ref					VARCHAR(255),
arti_deadline				INTEGER,
arti_name					VARCHAR(255),
arti_desc					VARCHAR(255),
arti_title					VARCHAR(255),
arti_subtitle				VARCHAR(255),
arti_page					INTEGER,

layout_generic_name			VARCHAR(255),
config_id					INTEGER,

arti_creator_id		INTEGER,
arti_creation_date			INTEGER,

arti_validator_id	INTEGER,
arti_validation_date		INTEGER,
arti_validation_state		INTEGER,

arti_release_date			INTEGER,
docu_id						INTEGER,
ws_id						INTEGER,

PRIMARY KEY (arti_id), 
KEY idx_!IdxNom!_arti_deadline (arti_deadline),
KEY idx_!IdxNom!_config_id (config_id),
KEY idx_!IdxNom!_docu_id (docu_id),
KEY idx_!IdxNom!_ws_id (ws_id)

);

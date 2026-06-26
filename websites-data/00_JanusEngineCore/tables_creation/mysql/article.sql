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
arti_id 					BINARY(16) NOT NULL UNIQUE, 
arti_id_str					CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(arti_id))),
arti_ref					VARCHAR(255),
arti_slug					VARCHAR(255),
fk_deadline_id				BINARY(16),
arti_name					VARCHAR(255),
arti_desc					VARCHAR(255),
arti_title					VARCHAR(255),
arti_subtitle				VARCHAR(255),
arti_page					INTEGER,

layout_generic_name			VARCHAR(255),
fk_config_id				BINARY(16),

arti_creator_id				BINARY(16),
arti_creation_date			INTEGER,

arti_validator_id			BINARY(16),
arti_validation_date		INTEGER,
arti_validation_state		INTEGER,

arti_release_date			INTEGER,
fk_docu_id					BINARY(16),
fk_ws_id					BINARY(16),

PRIMARY KEY (arti_id), 
KEY idx_!IdxNom!_deadline_id (fk_deadline_id),
KEY idx_!IdxNom!_config_id (fk_config_id),
KEY idx_!IdxNom!_docu_id (fk_docu_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);

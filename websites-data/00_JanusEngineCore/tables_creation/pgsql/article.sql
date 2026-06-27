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
arti_id 					BYTEA NOT NULL UNIQUE, 
arti_ref					VARCHAR(255),
arti_slug					VARCHAR(255),
fk_deadline_id				BYTEA,
arti_name					VARCHAR(255),
arti_desc					VARCHAR(255),
arti_title					VARCHAR(255),
arti_subtitle				VARCHAR(255),
arti_page					INTEGER,

layout_generic_name			VARCHAR(255),
fk_config_id				BYTEA,

arti_creator_id				BYTEA,
arti_creation_date			INTEGER,

arti_validator_id			BYTEA,
arti_validation_date		INTEGER,
arti_validation_state		INTEGER,

arti_release_date			INTEGER,
fk_docu_id					BYTEA,
fk_ws_id					BYTEA,

PRIMARY KEY (arti_id)




);

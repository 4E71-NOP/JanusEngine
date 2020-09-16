/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
arti_type					WMCODE 0	NOCODE 1	PHP 2	MIXED 3
arti_show_info				SHOW_INFO_OFF 0	SHOW_INFO_ON 1
arti_validation_etat		NON_VALIDE 0	VALIDE 1
arti_correction_etat		NON_CORRIGE 0 CORRIGE 1
*/

CREATE TABLE !table! (
arti_id 					INTEGER NOT NULL,
arti_ref					VARCHAR(255),
arti_bouclage				INTEGER,
arti_nom					VARCHAR(255),
arti_desc					VARCHAR(255),
arti_titre					VARCHAR(255),
arti_sous_titre				VARCHAR(255),
arti_page					INTEGER,

pres_nom_generique			VARCHAR(255),
config_id					INTEGER,

arti_creation_createur		INTEGER,
arti_creation_date			INTEGER,

arti_validation_validateur	INTEGER,
arti_validation_date		INTEGER,
arti_validation_etat		INTEGER,

arti_parution_date			INTEGER,
docu_id						INTEGER,
site_id						INTEGER,

PRIMARY KEY (arti_id), 
KEY idx_!IdxNom!_arti_bouclage (arti_bouclage),
KEY idx_!IdxNom!_config_id (config_id),
KEY idx_!IdxNom!_docu_id (docu_id),
KEY idx_!IdxNom!_site_id (site_id)

);

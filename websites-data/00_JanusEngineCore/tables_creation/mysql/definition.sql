/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
def_id 					BIGINT NOT NULL UNIQUE, 
def_name 				VARCHAR(255),
def_number				INTEGER,
def_text				VARCHAR(255),

PRIMARY KEY (def_id),
KEY idx_!IdxNom!_def_id (def_id)


);


/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
def_id 					BINARY(16) NOT NULL UNIQUE, 
def_id_str 				CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(def_id))),
def_name 				VARCHAR(255),
def_number				INTEGER,
def_text				VARCHAR(255),

PRIMARY KEY (def_id),
KEY idx_!IdxNom!_def_id (def_id)


);


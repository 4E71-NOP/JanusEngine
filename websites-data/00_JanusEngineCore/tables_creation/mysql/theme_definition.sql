/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
fk_theme_id		
def_type 
	0 -> integer
	1 -> varchar
*/

CREATE TABLE !table! (
def_id			BINARY(16) NOT NULL UNIQUE, 
def_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(def_id))),
fk_theme_id		BINARY(16),
def_type		INTEGER DEFAULT 0,
def_name		VARCHAR(255),
def_number		INTEGER DEFAULT 0,
def_string		VARCHAR(255),
PRIMARY KEY (def_id)
);

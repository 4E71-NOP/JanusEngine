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
def_id			BYTEA NOT NULL UNIQUE, 
fk_theme_id		BYTEA,
def_type		INTEGER DEFAULT 0,
def_name		VARCHAR(255),
def_number		INTEGER DEFAULT 0,
def_string		VARCHAR(255),
PRIMARY KEY (def_id)
);

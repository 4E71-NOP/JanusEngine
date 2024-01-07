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
def_id			BIGINT NOT NULL UNIQUE, 
fk_theme_id		BIGINT,
def_type		INTEGER DEFAULT 0,
def_name		VARCHAR(255),
def_number		BIGINT DEFAULT 0,
def_string		VARCHAR(255),
PRIMARY KEY (def_id)
);

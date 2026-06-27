/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
deco_line_number		BYTEA NOT NULL UNIQUE, 
fk_deco_id				BYTEA,
deco_variable_name		VARCHAR(255),
deco_value				VARCHAR(255),

PRIMARY KEY (deco_line_number)


);

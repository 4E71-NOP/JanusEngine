/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
deco_line_number		BINARY(16) NOT NULL UNIQUE, 
deco_line_number_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(deco_line_number))),
fk_deco_id				BINARY(16),
deco_variable_name		VARCHAR(255),
deco_value				VARCHAR(255),

PRIMARY KEY (deco_line_number),
KEY idx_!IdxNom!_deco_id (fk_deco_id)

);

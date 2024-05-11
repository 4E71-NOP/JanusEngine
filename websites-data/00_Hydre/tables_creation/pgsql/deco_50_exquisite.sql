/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
deco_line_number	BIGINT NOT NULL UNIQUE, 
fk_deco_id			BIGINT,
deco_variable_name	VARCHAR(255),
deco_value			VARCHAR(255),

PRIMARY KEY (deco_line_number)

);

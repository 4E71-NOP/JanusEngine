/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
deco_line_number		INTEGER NOT NULL,
fk_deco_id			INTEGER,
deco_variable_name	VARCHAR(255),
deco_value		VARCHAR(255),

PRIMARY KEY (deco_line_number),
KEY idx_!IdxNom!_deco_id (fk_deco_id)

);

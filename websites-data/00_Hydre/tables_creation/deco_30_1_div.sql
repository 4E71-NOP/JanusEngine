/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
deco_nligne		INTEGER NOT NULL,
deco_id			INTEGER,
deco_variable	VARCHAR(255),
deco_valeur		VARCHAR(255),

PRIMARY KEY (deco_nligne),
KEY idx_!IdxNom!_deco_id (deco_id)

);

/* ---------------------------------------- */
/* Foreign keys: config_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
config_id				INTEGER NOT NULL, 
fk_ws_id				INTEGER, 
fk_extension_id			INTEGER,
extension_variable		VARCHAR(255), 
extension_value		VARCHAR(255), 

PRIMARY KEY (config_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_extension_id (fk_extension_id)

);

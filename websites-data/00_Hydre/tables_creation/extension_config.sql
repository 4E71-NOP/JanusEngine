/* ---------------------------------------- */
/* Foreign keys: config_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
config_id				INTEGER NOT NULL, 
site_id					INTEGER, 
extension_id			INTEGER,
extension_variable		VARCHAR(255), 
extension_valeur		VARCHAR(255), 

PRIMARY KEY (config_id),
KEY idx_!IdxNom!_site_id (site_id),
KEY idx_!IdxNom!_extension_id (extension_id)

);

/* ---------------------------------------- */
/* Foreign keys: extension_id							*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
file_id					INTEGER NOT NULL, 
fk_extension_id			INTEGER,
extension_name			VARCHAR(255), 
file_name				VARCHAR(255), 
file_generic_name		VARCHAR(255), 
file_type				INTEGER, 

PRIMARY KEY (file_id),
KEY idx_!IdxNom!_extension_id (fk_extension_id)

);

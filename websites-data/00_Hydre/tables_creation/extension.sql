/* ---------------------------------------- */
/* Foreign keys: extension_id				*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extension_id			INTEGER NOT NULL, 
fk_ws_id				INTEGER NOT NULL, 
extension_name			VARCHAR(255), 
extension_version		VARCHAR(255), 
extension_author		VARCHAR(255), 
extension_author_website	VARCHAR(255), 
extension_exec			VARCHAR(255), 
extension_directory	VARCHAR(255), 

PRIMARY KEY (extension_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);

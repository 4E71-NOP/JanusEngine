/* ---------------------------------------- */
/* Foreign keys: extension_id				*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extension_id			INTEGER NOT NULL, 
site_id					INTEGER NOT NULL, 
extension_nom			VARCHAR(255), 
extension_version		VARCHAR(255), 
extension_auteur		VARCHAR(255), 
extension_site_auteur	VARCHAR(255), 
extension_exec			VARCHAR(255), 
extension_repertoire	VARCHAR(255), 

PRIMARY KEY (extension_id),
KEY idx_!IdxNom!_site_id (site_id)

);

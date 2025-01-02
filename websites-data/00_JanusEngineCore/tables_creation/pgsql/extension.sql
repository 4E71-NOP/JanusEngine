/* ---------------------------------------- */
/* Foreign keys: extension_id				*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extension_id				BIGINT NOT NULL UNIQUE, 
fk_ws_id					BIGINT, 
extension_name				VARCHAR(255), 
extension_version			VARCHAR(255), 
extension_author			VARCHAR(255), 
extension_author_website	VARCHAR(255), 
extension_exec				VARCHAR(255), 
extension_directory			VARCHAR(255), 

PRIMARY KEY (extension_id)

);

/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
dependency_id		INTEGER NOT NULL, 
extension_id		INTEGER, 
extension_dep		INTEGER, 

PRIMARY KEY (dependency_id),
KEY idx_!IdxNom!_dependency_id (dependency_id)

);

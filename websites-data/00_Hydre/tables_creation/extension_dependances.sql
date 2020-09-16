/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
dependance_id		INTEGER NOT NULL, 
extension_id		INTEGER, 
extension_dep		INTEGER, 

PRIMARY KEY (dependance_id),
KEY idx_!IdxNom!_extension_id (extension_id)

);

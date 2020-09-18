/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
dependence_id		INTEGER NOT NULL, 
extension_id		INTEGER, 
extension_dep		INTEGER, 

PRIMARY KEY (dependence_id),
KEY idx_!IdxNom!_extension_id (extension_id)

);
